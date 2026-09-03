#!/bin/bash

set -e  # Exit immediately if any command fails

# STEP -> INSTALL CRON Section
echo ""
echo "========================================="
echo "INSTALL CRON"
echo "========================================="


sudo apt install -y cron

echo "Enable Cron"
sudo systemctl start cron
sudo systemctl enable cron
sudo systemctl status cron
