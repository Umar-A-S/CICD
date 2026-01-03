#!/bin/bash
set -e

echo "== Deploy Selaksa App =="

cd /var/www/html/selaksa-app

echo "→ Pull latest code"
git pull origin main

echo "→ Build & run containers"
docker compose down
docker compose up -d --build

echo "→ Fix permission"
docker exec laravel_app chown -R www-data:www-data storage bootstrap/cache
docker exec laravel_app chmod -R 775 storage bootstrap/cache

echo "→ Clear cache"
docker exec laravel_app php artisan config:clear
docker exec laravel_app php artisan view:clear
docker exec laravel_app php artisan route:clear

echo "✅ Deploy success"
