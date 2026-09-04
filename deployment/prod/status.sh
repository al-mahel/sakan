#!/bin/bash

set -e  # Exit immediately if any command fails

# Change to script directory
cd /home/prod/app/backend
echo "📁 Working directory: $(pwd)"


# Load environment variables
if [ -f .env ]; then
    set -a
    source .env
    set +a
    echo "✅ Environment variables loaded successfully"
fi

# Check webhook URL
if [ -z "$DISCORD_STATUS_WEBHOOK" ]; then
    echo "Error: DISCORD_STATUS_WEBHOOK not set"
    exit 1
fi
echo "✅ Discord webhook URL found"


# Function to format bytes with all units
format_bytes_all() {
    local bytes=$1
    if [ $bytes -eq 0 ]; then
        echo "0 B (0 B)"
        return
    fi

    local b=$bytes
    local kb=$(echo "scale=2; $b/1024" | bc)
    local mb=$(echo "scale=2; $b/1048576" | bc)
    local gb=$(echo "scale=2; $b/1073741824" | bc)
    local tb=$(echo "scale=2; $b/1099511627776" | bc)

    # Determine the best unit for display
    if [ $b -lt 1024 ]; then
        echo "${b} B"
    elif [ $b -lt 1048576 ]; then
        echo "${kb} KB"
    elif [ $b -lt 1073741824 ]; then
        echo "${mb} MB"
    elif [ $b -lt 1099511627776 ]; then
        echo "${gb} GB"
    else
        echo "${tb} TB"
    fi
}

# Collect VPS info
echo "📊 Collecting VPS status..."
RAM_TOTAL=$(free -b | awk '/Mem:/ {print $2}')
RAM_USED=$(free -b | awk '/Mem:/ {print $3}')
RAM_AVAILABLE=$(free -b | awk '/Mem:/ {print $7}')
CPU_CORES=$(nproc)
DISK_TOTAL=$(df -B1 / | awk 'NR==2 {print $2}')
DISK_USED=$(df -B1 / | awk 'NR==2 {print $3}')
DISK_AVAILABLE=$(df -B1 / | awk 'NR==2 {print $4}')


# Media folder info
echo "📁 Collecting media status..."
if [ -d "/home/prod/app/backend/storage/" ]; then
    MEDIA_FILES=$(find /home/prod/app/backend/storage/ -type f 2>/dev/null | wc -l)
    MEDIA_SIZE=$(du -sb /home/prod/app/backend/storage/ 2>/dev/null | cut -f1)
else
    MEDIA_FILES=0
    MEDIA_SIZE=0
fi


# MySQL info
echo "🐘 Collecting MySQL status..."
# MySQL memory usage (approximate - RSS from processlist)
MYSQL_MEMORY=$(ps aux | grep mysqld | grep -v grep | awk '{sum+=$6} END {print sum*1024}')
[ -z "$MYSQL_MEMORY" ] && MYSQL_MEMORY=0

# MySQL database size (replace DB_NAME with your actual database name)
MYSQL_DB_SIZE=$(mysql -N -e "SELECT SUM(data_length + index_length) FROM information_schema.tables WHERE table_schema = '$DB_NAME';" 2>/dev/null)
[ -z "$MYSQL_DB_SIZE" ] && MYSQL_DB_SIZE=0

# Log folder
echo "📋 Collecting log status..."
LOG_SIZE=$(du -sb /var/log 2>/dev/null | cut -f1)
[ -z "$LOG_SIZE" ] && LOG_SIZE=0

# Health check
echo "❤️ Checking health endpoint..."
HEALTH_BODY=$(curl -s --max-time 5 http://127.0.0.1/up 2>/dev/null)
HEALTH_STATUS="$HEALTH_BODY"

# Certificate
CERT_INFO=$(sudo certbot certificates 2>/dev/null)
DOMAINS=$(echo "$CERT_INFO" | grep "Certificate Name:" | awk '{print $3}')
EXPIRY=$(echo "$CERT_INFO" | grep "Expiry Date:" | sed 's/.*Expiry Date: //')

# Build message
CERTIFICATE_MESSAGE="\`\`\`$(echo "$CERT_INFO" | grep -E "(Certificate Name:|Expiry Date:|Domains:)")\`\`\`"

# Create JSON payload with embeds
echo "📝 Building VPS Status Discord message..."
MESSAGE="📊 **Server Status Report** - $(date '+%Y-%m-%d %H:%M:%S')

🖥️ **VPS Status**
• RAM: $(format_bytes_all $RAM_USED) ( $(echo "scale=1; $RAM_USED*100/$RAM_TOTAL" | bc)% ) / $(format_bytes_all $RAM_TOTAL)
• Disk Total: $(format_bytes_all $DISK_AVAILABLE) ( $(echo "scale=1; $DISK_USED*100/$DISK_TOTAL" | bc)% ) / $(format_bytes_all $DISK_TOTAL)

📁 **Media Folder**
• Files: $(echo $MEDIA_FILES | numfmt --grouping)
• Size: $(format_bytes_all $MEDIA_SIZE)

🐘 **PostgreSQL**
• RAM Used: $(format_bytes_all $PG_MEMORY)
• DB Size: $(format_bytes_all $PG_DB_SIZE)

📋 **Logs**
• Logs Size: $(format_bytes_all $LOG_SIZE)

❤️ **Health Check**
$HEALTH_STATUS

**🔐 SSL Certificate Status**
$CERTIFICATE_MESSAGE"


# Create JSON payload using jq
JSON_PAYLOAD=$(jq -n \
    --arg content "$MESSAGE" \
    --arg username "$SERVER_NAME Server Monitor" \
    '{content: $content, username: $username}')
echo "✅ JSON payload created"


# Send to Discord
echo "📤 Sending VPS Status to Discord..."
RESPONSE=$(curl -s -w "%{http_code}" -X POST -H "Content-Type: application/json" \
    -d "$JSON_PAYLOAD" \
    "$DISCORD_STATUS_WEBHOOK" 2>/dev/null)

if [ "$RESPONSE" = "204" ]; then
    echo "✅ Status report sent to Discord successfully!"
else
    echo "❌ Failed to send to Discord. HTTP Code: $RESPONSE"
    echo "Error details:"
    echo "$RESPONSE"
    exit 1
fi
