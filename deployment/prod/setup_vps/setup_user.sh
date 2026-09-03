#!/bin/bash

set -e  # Exit immediately if any command fails



# STEP -> Create USER Setup Section
echo ""
echo "========================================="
echo "Create USER"
echo "========================================="

# Load environment variables
if [ -f /root/.env ]; then
    set -a
    source /root/.env
    set +a
    echo "✅ Environment variables loaded successfully"
fi

# Set variables for user creation
# NEW_USER=                    => ALREADY DEFINED IN ENV
# NEW_USER_PASS=               => ALREADY DEFINED IN ENV
TARGET_USER="$NEW_USER"

if id "$NEW_USER" &>/dev/null; then
    echo "User '$NEW_USER' already exists."
else
    echo "Creating user '$NEW_USER'..."
    useradd -m -s /bin/bash "$NEW_USER"
    echo "$NEW_USER:$NEW_USER_PASS" | chpasswd
    usermod -aG sudo "$NEW_USER"
    echo "User '$NEW_USER' created and added to sudo group."
fi
