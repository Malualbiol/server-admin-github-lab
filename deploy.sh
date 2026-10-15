#!/bin/bash

set -e

REPO_DIR="$HOME/server-admin-github-lab"
WEB_DIR="/var/www/lamp-site"

echo "Pulling latest code from GitHub..."
cd "$REPO_DIR"
git pull origin main

echo "Deploying website..."
rsync -av --delete \
    --exclude='.git' \
    --exclude='deploy.sh' \
    "$REPO_DIR/" "$WEB_DIR/"

echo "Deployment complete."
