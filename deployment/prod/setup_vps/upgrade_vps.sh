#!/bin/bash

set -e  # Exit immediately if any command fails



# STEP -> Upgrade to Ubuntu 24 Setup Section
echo ""
echo "========================================="
echo "Upgrade to Ubuntu 24"
echo "========================================="




# Function to check if a package is installed
is_installed() {
    dpkg -l | grep -q "^ii.*$1"
}

# Function to get Ubuntu version
get_ubuntu_version() {
    lsb_release -rs
}

CURRENT_VERSION=$(get_ubuntu_version)
echo "Current Ubuntu Version: $CURRENT_VERSION"

if [[ "$CURRENT_VERSION" < "24.04" ]]; then
    echo "Upgrading Ubuntu $CURRENT_VERSION to 24.04..."

    read -p "Are you sure you want to continue with upgrade? (y/n): " -n 1 -r
    echo
    if [[ ! $REPLY =~ ^[Yy]$ ]]; then
        echo "Upgrade cancelled."
        exit 1
    fi

    # Update current system
    apt update
    apt upgrade
    apt full-upgrade
    apt autoremove

    # Install update manager
    apt install update-manager-core

    # Configure for LTS upgrade
    if [ -f /etc/update-manager/release-upgrades ]; then
        sed -i 's/Prompt=.*/Prompt=lts/' /etc/update-manager/release-upgrades
    fi

    # Perform upgrade
    do-release-upgrade

    if [ $? -eq 0 ]; then
        echo "Upgrade completed successfully!"
        echo "System will reboot in 10 seconds..."
        sleep 10
        reboot
    else
        echo "Upgrade failed!"
        exit 1
    fi
else
    echo "Ubuntu version is $CURRENT_VERSION - continuing with setup..."
fi
