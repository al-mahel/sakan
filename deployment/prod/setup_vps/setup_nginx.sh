#!/bin/bash

set -e  # Exit immediately if any command fails

echo ""
echo "========================================="
echo "INSTALL NGINX"
echo "========================================="


echo ""
echo "Checking Nginx..."
if ! is_installed nginx; then
    echo "Nginx not found. Installing..."
    apt install nginx
    systemctl enable nginx
    systemctl start nginx
    echo "Nginx installed successfully."
else
    echo "Nginx is already installed."
    exit 1
fi





echo ""
echo "Create Dummy Certificate"
sudo mkdir -p /etc/nginx/ssl && \
sudo openssl req -x509 -nodes -days 365 -newkey rsa:2048 \
  -keyout /etc/ssl/private/dummy.key \
  -out /etc/ssl/certs/dummy.crt \
  -subj "/C=US/ST=State/L=City/O=Dummy/OU=IT/CN=localhost" \
  -addext "subjectAltName=DNS:localhost,IP:127.0.0.1"





echo ""
echo "========================================="
echo "🌐 Configuring Nginx"
echo "========================================="

TARGET_HOME="/home/prod"
# Ask for nginx config file location
REPO_PATH="$TARGET_HOME/app/backend"
NGINX_SOURCE_FILE="nginx-sakan.com.conf"

# Remove default files
echo "Removing default nginx configurations..."
[ -L /etc/nginx/sites-enabled/default ] && unlink /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-enabled/default
rm -f /etc/nginx/sites-available/default
echo "✅ Default configs removed"

# Move your config file
echo "Installing your nginx configuration..."
cp $REPO_PATH/deployment/prod/nginx/nginx.conf /etc/nginx/nginx.conf
cp $REPO_PATH/deployment/prod/nginx/$NGINX_SOURCE_FILE /etc/nginx/sites-available/$NGINX_SOURCE_FILE
ln -sf /etc/nginx/sites-available/$NGINX_SOURCE_FILE /etc/nginx/sites-enabled/$NGINX_SOURCE_FILE

# Test and reload
nginx -t && systemctl reload nginx

if [ $? -eq 0 ]; then
    echo "✅ Nginx configured successfully!"
    systemctl status nginx --no-pager
else
    echo "❌ Nginx configuration failed"
    exit 1
fi
