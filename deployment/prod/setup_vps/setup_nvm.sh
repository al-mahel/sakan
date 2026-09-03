#!/bin/bash

set -e  # Exit immediately if any command fails


# STEP -> NVM Setup Section
echo ""
echo "========================================="
echo "NVM Setup"
echo "========================================="

# Step 1 -> Install curl if not present
if ! is_installed curl; then
    apt update
    apt install -y curl
fi


sudo -u "prod" -H bash << 'EOF'

NVM_VERSION="v0.40.1"

# STEP -> Install NVM if not already installed
if [ -d "$HOME/.nvm" ]; then
    echo "NVM is already installed."
else
    echo "Installing NVM $NVM_VERSION..."
    sudo curl -o- "https://raw.githubusercontent.com/nvm-sh/nvm/$NVM_VERSION/install.sh" | bash

    if [ $? -eq 0 ]; then
        echo "✅ NVM installed successfully"
    else
        echo "❌ Failed to install NVM"
        exit 1
    fi
fi



# STEP -> Load NVM into the current shell session
export NVM_DIR="$HOME/.nvm"
[ -s "$NVM_DIR/nvm.sh" ] && \. "$NVM_DIR/nvm.sh"
[ -s "$NVM_DIR/bash_completion" ] && \. "$NVM_DIR/bash_completion"



# STEP -> Verify NVM is available
echo ""
echo "Checking NVM status..."
if command -v nvm >/dev/null 2>&1; then
    echo "✅ NVM is available in this shell"
else
    echo "❌ NVM command not found. You may need to restart your shell or re-source ~/.bashrc"
    exit 1
fi


echo ""
echo "========================================="
echo "NVM Setup Complete!"
echo "========================================="
nvm --version
echo "========================================="
echo ""


EOF
