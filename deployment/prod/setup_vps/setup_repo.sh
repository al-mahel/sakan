#!/bin/bash

set -e  # Exit immediately if any command fails

# STEP -> Setup Repo Section
echo ""
echo "========================================="
echo "SETUP REPO"
echo "========================================="


# Load environment variables
if [ -f /root/.env ]; then
    set -a
    source /root/.env
    set +a
    echo "✅ Environment variables loaded successfully"
fi


# Set variables for repository
# GITHUB_API_KEY=              =>  ALREADY DEFINED IN ENV
TARGET_USER=prod
REPO_URL="https://$GITHUB_API_KEY@github.com/al-mahel/sakan.git"  # Change this to your actual repo URL
TARGET_HOME="/home/$TARGET_USER"
APP_DIR="/home/prod/app/backend"
echo $TARGET_HOME


# STEP -> Setup requirements & Working App
echo ""
sudo -u "$TARGET_USER" bash << EOF

    # STEP -> Install Requirements
    sudo apt install -y \
        libfreetype6-dev \
        python3-dev \
        build-essential \
        libpq-dev \
        libjpeg-dev \
        libpng-dev \
        zlib1g-dev \
        python3.12-venv \
        gettext \
        jq \
        bc \
        logrotate


    # STEP -> Clone Repo
    cd "$TARGET_HOME"
    mkdir -p "app"
    cd "app"
    sudo git clone $REPO_URL backend
    sudo cp /root/.env $TARGET_HOME/app/backend/.env
    echo "Repository setup complete for user '$TARGET_USER' at $TARGET_HOME/app/backend"


    # STEP -> Install FE dependencies
    nvm install v20
    nvm use v20
    npm install
    npm run build


    # STEP -> Install PHP dependencies
    echo ""
    echo "Installing Composer dependencies..."
    composer install --no-dev --optimize-autoloader --no-interaction
    if [ $? -eq 0 ]; then
        echo "✅ Composer dependencies installed"
    else
        echo "❌ composer install failed"
        exit 1
    fi


    echo "Generate Key..."
    php artisan key:generate

    echo "Migrate..."
    php artisan migrate

    echo "Link Storage..."
    php artisan storage:link



    echo ""
    echo "Caching config/routes/views..."
    php artisan config:cache
    php artisan route:cache
    php artisan view:cache
    echo "✅ Caches built"



    echo ""
    echo "Setting permissions..."
    chown -R "prod":"www-data" "$APP_DIR"
    chmod -R 775 "$APP_DIR/storage" "$APP_DIR/bootstrap/cache"
    echo "✅ Permissions set"
EOF



echo ""
echo "========================================="
echo "Sakan App Setup Complete!"
echo "========================================="
echo "App dir: $APP_DIR"
echo "APP_URL: https://skntalaba.com"
echo "========================================="
echo ""
