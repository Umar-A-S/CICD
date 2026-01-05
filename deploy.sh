#!/bin/bash

# Konfigurasi Path
PROJECT_DIR="/var/www/html/selaksa-app"
LOG="$PROJECT_DIR/deploy.log"

# Mengarahkan output ke log
exec >> "$LOG" 2>&1

# Mulai Hitung Waktu
START_TIME=$(date +%s)

echo ""
echo "#######################################################"
echo "🚀 DEPLOYMENT STARTED: $(date '+%Y-%m-%d %H:%M:%S')"
echo "#######################################################"

cd "$PROJECT_DIR" || { echo "❌ ERROR: Folder project tidak ditemukan!"; exit 1; }

echo "🔍 Checking for updates from GitHub..."
git fetch origin main

LOCAL=$(git rev-parse HEAD)
REMOTE=$(git rev-parse origin/main)

if [ "$LOCAL" = "$REMOTE" ]; then
    echo "✅ [$(date '+%H:%M:%S')] Status: Up to date. Nothing to deploy."
    echo "-------------------------------------------------------"
    exit 0
fi

# Cek apakah ada perubahan pada composer.json atau composer.lock
CHANGES_IN_COMPOSER=$(git diff --name-only $LOCAL $REMOTE | grep 'composer.')

echo "📦 Changes detected! Starting pull..."
git pull origin main

# Jalankan Composer Install HANYA jika ada perubahan library
if [ ! -z "$CHANGES_IN_COMPOSER" ]; then
    echo "📦 Composer changes detected. Installing dependencies..."
    docker compose exec -T app composer install --no-dev --optimize-autoloader
else
    echo "⏩ No composer changes. Skipping composer install."
fi

echo "⚙️  Optimizing Laravel inside container..."

# Membersihkan cache dan optimasi (Tanpa Migration)
docker compose exec -T app sh -c "
    php artisan config:clear && \
    php artisan route:clear && \
    php artisan view:clear && \
    php artisan cache:clear && \
    php artisan optimize
"

# Set Permission ulang (Penting jika ada file baru dari git pull)
echo "🔒 Fixing permissions..."
sudo chown -R $USER:www-data "$PROJECT_DIR"
sudo chmod -R 775 "$PROJECT_DIR/storage" "$PROJECT_DIR/bootstrap/cache"

# Hitung Durasi
END_TIME=$(date +%s)
DURATION=$((END_TIME - START_TIME))

echo "#######################################################"
echo "✅ DEPLOYMENT FINISHED SUCCESSFULLY!"
echo "⏱️  Duration: $DURATION seconds"
echo "📅 Finished at: $(date '+%Y-%m-%d %H:%M:%S')"
echo "#######################################################"
echo ""
