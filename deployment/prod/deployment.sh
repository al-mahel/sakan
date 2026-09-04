#!/bin/bash

set -e  # Exit immediately if any command fails

cd /home/prod/app/backend

git checkout releases
git pull

# Load environment variables
if [ -f .env ]; then
    set -a
    source .env
    set +a
    echo "✅ Environment variables loaded successfully"
fi


# Build PHP Dependencies
composer install --no-dev --optimize-autoloader --no-interaction


# Build Laravel
php artisan key:generate --force
php artisan migrate --force
php artisan storage:link --force


# Build Caching
php artisan config:cache
php artisan route:cache
php artisan view:cache


curl -sf https://www.skntalaba.com/up -o /dev/null

echo ""
echo "Configure Running Crons..."

cd deployment/prod

sudo cp sakan_cronjobs /etc/cron.d/sakan_cronjobs
sudo chown root:root /etc/cron.d/sakan_cronjobs
sudo chmod 644 /etc/cron.d/sakan_cronjobs

# Sync Scripts
sudo mkdir -p /etc/sakan_scripts/

sudo cp status.sh /etc/sakan_scripts/status.sh
sudo chmod +x /etc/sakan_scripts/status.sh

sudo systemctl restart cron
