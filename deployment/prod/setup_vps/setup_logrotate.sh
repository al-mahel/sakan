#!/bin/bash

set -e  # Exit immediately if any command fails

# STEP -> Setup Log Rorate Section
echo ""
echo "========================================="
echo "SETUP LOG ROTATE"
echo "========================================="

sudo apt install -y logrotate
