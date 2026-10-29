#!/usr/bin/env bash
set -e

echo "🚀 Starting Deployment for Photobooth..."
cd /home/bagus/galery-photobooth

echo "📥 Pulling latest changes from git..."
git pull origin main

echo "📦 Installing npm dependencies & building assets..."
npm install --no-audit
npm run build

echo "🐘 Installing Composer dependencies via PHP 8.4 container..."
docker run --rm -v /home/bagus/galery-photobooth:/app -w /app composer:latest composer install --no-interaction --prefer-dist --optimize-autoloader

echo "🔄 Restarting Photobooth container..."
docker restart photobooth-app

echo "🗄️ Running migrations & clearing cache..."
docker exec photobooth-app php artisan migrate --force
docker exec photobooth-app php artisan optimize:clear

echo "✅ Deployment completed successfully!"
