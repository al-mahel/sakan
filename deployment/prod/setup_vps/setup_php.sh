#!/bin/bash

set -e  # Exit immediately if any command fails


# STEP -> PHP Setup Section
echo ""
echo "========================================="
echo "PHP Setup"
echo "========================================="

PHP_VERSION="8.3"

# STEP -> Add ondrej/php PPA (needed for PHP 8.3+ on most Ubuntu releases)
if ! is_installed software-properties-common; then
    apt update
    apt install -y software-properties-common
fi

if ! grep -q "^deb .*ondrej/php" /etc/apt/sources.list.d/*.list 2>/dev/null; then
    echo "Adding ondrej/php PPA..."
    add-apt-repository -y ppa:ondrej/php
    apt update
else
    echo "ondrej/php PPA already added."
fi



# STEP -> Install PHP and required extensions for Laravel
if ! is_installed php$PHP_VERSION; then
    echo "PHP $PHP_VERSION not found. Installing..."
    # Ctype, Fileinfo, JSON, OpenSSL, PDO, and Tokenizer ship inside php-common/core,
    # so only the extensions below need their own packages.
    apt install -y \
        php$PHP_VERSION \
        php$PHP_VERSION-fpm \
        php$PHP_VERSION-cli \
        php$PHP_VERSION-common \
        php$PHP_VERSION-bcmath \
        php$PHP_VERSION-mbstring \
        php$PHP_VERSION-mysql \
        php$PHP_VERSION-xml \
        php$PHP_VERSION-intl \
        php$PHP_VERSION-zip

    if [ $? -eq 0 ]; then
        echo "✅ PHP $PHP_VERSION installed successfully"
    else
        echo "❌ Failed to install PHP $PHP_VERSION"
        exit 1
    fi
else
    echo "PHP $PHP_VERSION is already installed."
fi



# STEP -> Set PHP $PHP_VERSION as the default CLI version
echo ""
echo "Setting PHP $PHP_VERSION as default CLI version..."
update-alternatives --set php /usr/bin/php$PHP_VERSION 2>/dev/null
echo "✅ Default CLI PHP set to $PHP_VERSION"



# STEP -> Enable and start php-fpm
echo ""
echo "Starting php$PHP_VERSION-fpm..."
systemctl enable php$PHP_VERSION-fpm
systemctl start php$PHP_VERSION-fpm

if systemctl is-active --quiet php$PHP_VERSION-fpm; then
    echo "✅ php$PHP_VERSION-fpm is running"
else
    echo "❌ php$PHP_VERSION-fpm failed to start"
    exit 1
fi



# STEP -> Install Composer if not installed
if ! is_installed composer; then
    echo ""
    echo "Installing Composer..."
    php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
    php composer-setup.php --install-dir=/usr/local/bin --filename=composer
    rm composer-setup.php

    if [ $? -eq 0 ]; then
        echo "✅ Composer installed successfully"
    else
        echo "❌ Failed to install Composer"
        exit 1
    fi
else
    echo "Composer is already installed."
fi



echo ""
echo "========================================="
echo "PHP Setup Complete!"
echo "========================================="
php -v
echo ""
composer -V
echo ""
echo "Installed extensions check:"
for ext in bcmath ctype fileinfo json mbstring openssl pdo pdo_mysql tokenizer xml; do
    if php -m | grep -qi "^$ext$"; then
        echo "✅ $ext"
    else
        echo "❌ $ext missing"
    fi
done
echo "========================================="
echo ""
