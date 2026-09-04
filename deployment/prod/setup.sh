#!/usr/bin/env bash
set -e

# ==========================================
# Central Setup Script
# Runs individual setup scripts in order
# ==========================================


# Load environment variables
if [ -f /root/.env ]; then
    set -a
    source /root/.env
    set +a
    echo "✅ Environment variables loaded successfully"
fi


# GITHUB_API_KEY=""  =>  ALREADY DEFINED IN ENV
SCRIPTS_BASE_URL="https://api.github.com/repos/al-mahel/sakan/contents/deployment/prod/setup_vps"
SCRIPT_DIR="/opt/sakan"
mkdir -p "$SCRIPT_DIR"

run_step() {
    local operation_name="$1"
    local script_name="$2"

    echo ""
    echo "#########################################"
    echo "# Running: $operation_name"
    echo "#########################################"

    echo "Downloading $script_name..."
    curl -fsSL \
        -H "Authorization: Bearer $GITHUB_API_KEY" \
        -H "Accept: application/vnd.github.raw" \
        -o "$SCRIPT_DIR/$script_name" "$SCRIPTS_BASE_URL/$script_name?ref=releases"

    if [ ! -f "$SCRIPT_DIR/$script_name" ]; then
        echo "❌ Script not found: $SCRIPT_DIR/$script_name"
        exit 1
    fi

    chmod +x "$SCRIPT_DIR/$script_name"
    sudo bash "$SCRIPT_DIR/$script_name"

    if [ $? -eq 0 ]; then
        echo "✅ $operation_name completed"
    else
        echo "❌ $operation_name failed. Stopping."
        exit 1
    fi
}

run_step "Upgrade VPS" "upgrade_vps.sh"
run_step "Setup User" "setup_user.sh"
run_step "MySQL Setup" "setup_mysql.sh"
run_step "Setup Firewall" "setup_firewall.sh"
run_step "Setup NVM" "setup_nvm.sh"
run_step "Setup PHP" "setup_php.sh"
run_step "Configure Journald" "setup_journald.sh"
run_step "Setup Logrotate" "setup_logrotate.sh"
run_step "Setup Cron" "setup_cron.sh"
run_step "Setup Repo" "setup_repo.sh"
run_step "Setup Nginx" "setup_nginx.sh"
run_step "Setup Let's Encrypt" "setup_lets_encrypt.sh"

echo ""
echo "#########################################"
echo "# All steps completed successfully!"
echo "#########################################"
echo ""
