#!/bin/bash

set -e  # Exit immediately if any command fails

echo ""
echo "========================================="
echo "INSTALL LET'S ENCRYPT"
echo "========================================="



echo ""
echo "Setting up Let's Encrypt..."
if ! is_installed certbot; then
    echo "Installing Certbot..."
    apt install certbot python3-certbot-nginx
fi



APP_DOMAIN="www.skntalaba.com"

read -p "Do you want to run Let's Encrypt for SSL certificate? (y/n): " -n 1 -r
echo
if [[ $REPLY =~ ^[Yy]$ ]]; then
    certbot --nginx -d $APP_DOMAIN
    echo "Let's Encrypt SSL certificate obtained for $APP_DOMAIN"
else
    echo "Skipping Let's Encrypt setup."
fi
