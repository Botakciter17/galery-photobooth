#!/usr/bin/env bash
set -e

export PATH="/usr/local/sbin:/usr/local/bin:/usr/sbin:/usr/bin:/sbin:/bin:$PATH"

echo "🚀 Starting Deployment for Photobooth..."
cd /home/bagus/galery-photobooth

echo "📥 Fetching & resetting to latest origin/main..."
git fetch origin main
git reset --hard origin/main

echo "📦 Installing npm dependencies & building assets..."
npm install --no-audit
npm run build

echo "🐘 Installing Composer dependencies via container..."
docker run --rm -v /home/bagus/galery-photobooth:/app -w /app composer:latest composer install --no-interaction --prefer-dist --optimize-autoloader

echo "🔄 Restarting Photobooth container..."
docker restart photobooth-app

echo "🗄️ Running migrations & clearing cache..."
docker exec photobooth-app php artisan migrate --force
docker exec photobooth-app php artisan optimize:clear

echo "✅ Deployment completed successfully!"
