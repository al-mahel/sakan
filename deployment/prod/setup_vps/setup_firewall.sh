#!/bin/bash

set -e  # Exit immediately if any command fails


# STEP -> Upgrade to Ubuntu 24 Setup Section
echo ""
echo "========================================="
echo "Install Firewall"
echo "========================================="



# STEP -> Uninstall firewalld if installed
echo ""
echo "Step 4: Checking firewalld..."
if is_installed firewalld; then
    echo "firewalld found. Uninstalling..."
    systemctl stop firewalld
    systemctl disable firewalld
    apt remove firewalld
    apt autoremove
    echo "firewalld removed successfully."
else
    echo "firewalld is not installed."
fi



# STEP -> Install and configure UFW
echo ""
echo "Step 5: Setting up UFW..."
if ! is_installed ufw; then
    echo "UFW not found. Installing..."
    apt install ufw

    # Configure UFW rules
    echo "Configuring UFW rules..."
    ufw allow 22/tcp comment 'SSH'
    ufw allow 80/tcp comment 'HTTP'
    ufw allow 443/tcp comment 'HTTPS'

    # Enable UFW
    echo "y" | ufw enable
    ufw status
    echo "UFW installed and configured successfully."
else
    echo "UFW is already installed. Checking rules..."
    ufw allow 22/tcp
    ufw allow 80/tcp
    ufw allow 443/tcp
    echo "UFW rules updated."
fi
