#!/bin/bash

set -e  # Exit immediately if any command fails


# STEP -> MySQL Setup Section
echo ""
echo "========================================="
echo "MySQL Setup"
echo "========================================="

# Load environment variables
if [ -f /root/.env ]; then
    set -a
    source /root/.env
    set +a
    echo "✅ Environment variables loaded successfully"
fi

# MYSQL_PORT=               => ALREADY DEFINED IN ENV
# MYSQL_ROOT_PASSWORD=      => ALREADY DEFINED IN ENV
# DB_NAME=                  => ALREADY DEFINED IN ENV
# DB_USER=                  => ALREADY DEFINED IN ENV
# DB_PASS=                  => ALREADY DEFINED IN ENV

# STEP -> Install MySQL with custom port if not installed
if ! is_installed mysql-server; then
    echo "MySQL not found. Installing..."
    apt update
    apt install -y mysql-server

    MYSQL_CONF_DIR="/etc/mysql/mysql.conf.d"
    MYSQL_CONF_FILE="$MYSQL_CONF_DIR/mysqld.cnf"

    if [ -f "$MYSQL_CONF_FILE" ]; then
        # Update port in mysqld.cnf
        sed -i "s/^port.*=.*3306/port = $MYSQL_PORT/" "$MYSQL_CONF_FILE"
        if ! grep -q "^port" "$MYSQL_CONF_FILE"; then
            sed -i "/\[mysqld\]/a port = $MYSQL_PORT" "$MYSQL_CONF_FILE"
        fi

        # Update bind-address to allow connections
        sed -i "s/^bind-address.*=.*127.0.0.1/bind-address = 0.0.0.0/" "$MYSQL_CONF_FILE"

        # Restart MySQL to apply changes
        systemctl restart mysql
        echo "MySQL configured to run on port $MYSQL_PORT"
    else
        echo "MySQL configuration file not found. Please check installation."
        exit 1
    fi
else
    echo "MySQL is already installed."
fi


echo ""
echo "========================================="
echo "MySQL Status"
echo "========================================="
systemctl status mysql --no-pager
echo ""
echo "Active: $(systemctl is-active mysql)"
echo "Port: $MYSQL_PORT"
echo "========================================="



# STEP -> Check status is working
echo ""
echo "Checking MySQL status..."
if systemctl is-active --quiet mysql; then
    echo "✅ MySQL is running"
else
    echo "❌ MySQL is not running. Starting..."
    systemctl start mysql
    sleep 2
    if systemctl is-active --quiet mysql; then
        echo "✅ MySQL started successfully"
    else
        echo "❌ Failed to start MySQL"
        exit 1
    fi
fi


# STEP -> Change root password
echo ""
echo "Changing root password..."
mysql -u root <<EOF
ALTER USER 'root'@'localhost' IDENTIFIED WITH mysql_native_password BY '$MYSQL_ROOT_PASSWORD';
FLUSH PRIVILEGES;
EOF

if [ $? -eq 0 ]; then
    echo "✅ Root password changed successfully"
else
    echo "❌ Failed to change root password"
    exit 1
fi



# STEP -> Try to connect with the new password
echo ""
echo "Testing connection with new password..."
if mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -e "SELECT 'Connection successful' AS status;" 2>/dev/null; then
    echo "✅ Successfully connected to MySQL with new password"
else
    echo "❌ Failed to connect with new password"
    exit 1
fi



# STEP -> Check if database exists, if not then create it
echo ""
echo "Checking if database '$DB_NAME' exists..."
DB_EXISTS=$(mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -N -B -e "SHOW DATABASES LIKE '$DB_NAME';" 2>/dev/null)

if [ "$DB_EXISTS" = "$DB_NAME" ]; then
    echo "✅ Database '$DB_NAME' already exists"
else
    echo "Database '$DB_NAME' does not exist. Creating..."
    mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE DATABASE $DB_NAME CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;" 2>/dev/null
    if [ $? -eq 0 ]; then
        echo "✅ Database '$DB_NAME' created successfully"
    else
        echo "❌ Failed to create database '$DB_NAME'"
        exit 1
    fi
fi



# STEP -> Connect to it
echo ""
echo "Connecting to database '$DB_NAME'..."
if mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -D "$DB_NAME" -e "SELECT 'Connected to $DB_NAME' AS status;" 2>/dev/null; then
    echo "✅ Successfully connected to database '$DB_NAME'"
else
    echo "❌ Failed to connect to database '$DB_NAME'"
    exit 1
fi


# STEP -> Create user with password
echo ""
echo "Creating user '$DB_USER'..."
USER_EXISTS=$(mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -N -B -e "SELECT 1 FROM mysql.user WHERE user='$DB_USER' AND host='%';" 2>/dev/null)

if [ "$USER_EXISTS" = "1" ]; then
    echo "User '$DB_USER' already exists. Updating password..."
    mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -e "ALTER USER '$DB_USER'@'%' IDENTIFIED BY '$DB_PASS';" 2>/dev/null
else
    mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -e "CREATE USER '$DB_USER'@'%' IDENTIFIED BY '$DB_PASS';" 2>/dev/null
    if [ $? -eq 0 ]; then
        echo "✅ User '$DB_USER' created successfully"
    else
        echo "❌ Failed to create user '$DB_USER'"
        exit 1
    fi
fi



# STEP -> Grant all permissions for the user to the db
echo ""
echo "Granting permissions to user '$DB_USER' on database '$DB_NAME'..."
mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -e "GRANT ALL PRIVILEGES ON \`$DB_NAME\`.* TO '$DB_USER'@'%';" 2>/dev/null
mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p"$MYSQL_ROOT_PASSWORD" -e "FLUSH PRIVILEGES;" 2>/dev/null
echo "✅ Permissions granted successfully"



# STEP -> Connect with this new user and check that it is working fine
echo ""
echo "Testing connection with new user '$DB_USER'..."
if mysql -h 127.0.0.1 -P $MYSQL_PORT -u "$DB_USER" -p"$DB_PASS" -D "$DB_NAME" -e "SELECT 'Successfully connected as $DB_USER' AS status;" 2>/dev/null; then
    echo "✅ Successfully connected to database '$DB_NAME' as user '$DB_USER'"

    # Test create table permission
    if mysql -h 127.0.0.1 -P $MYSQL_PORT -u "$DB_USER" -p"$DB_PASS" -D "$DB_NAME" -e "CREATE TABLE test_table (id int, name varchar(50));" 2>/dev/null; then
        echo "✅ Create table permission verified"
        mysql -h 127.0.0.1 -P $MYSQL_PORT -u "$DB_USER" -p"$DB_PASS" -D "$DB_NAME" -e "DROP TABLE test_table;" 2>/dev/null
        echo "✅ All permissions working correctly"
    else
        echo "⚠️ Create table permission issue detected"
    fi
else
    echo "❌ Failed to connect as user '$DB_USER'"
    exit 1
fi

echo ""
echo "========================================="
echo "MySQL Setup Complete!"
echo "========================================="
echo "Port: $MYSQL_PORT"
echo "Root Password: ......"
echo "Database: $DB_NAME"
echo "User: $DB_USER"
echo "User Password: ......"
echo ""
echo "Connection string (root):"
echo "  mysql -h 127.0.0.1 -P $MYSQL_PORT -u root -p -D $DB_NAME"
echo ""
echo "Connection string (application user):"
echo "  mysql -h 127.0.0.1 -P $MYSQL_PORT -u $DB_USER -p -D $DB_NAME"
echo ""
echo "To connect manually:"
echo "  mysql -h 127.0.0.1 -P $MYSQL_PORT -u $DB_USER -p'......' -D $DB_NAME"
echo ""
