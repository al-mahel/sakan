#!/bin/bash

set -e  # Exit immediately if any command fails

echo ""
echo "========================================="
echo "CONFIGURE JOURNALD"
echo "========================================="


echo ""
echo "Step Configure Journald..."

sudo journalctl --vacuum-size=300M

echo "✅ Journald Configured"

