# BENTUK DOCKERFILE DALAM STUKTUR MULTI-STAGE BUILD UNTUK APLIKASI LARAVEL

# ==========================================
# STAGE 1: Build (Sang "Tukang")
# ==========================================

# Gunakan image PHP 8.3 dengan FPM berbasis Alpine agar ringan 
FROM php:8.3-fpm-alpine AS builder

# Instal tools yang hanya dibutuhkan saat install (git, zip, dll)
RUN apk add --no-cache git unzip libpng-dev libxml2-dev libzip-dev oniguruma-dev nodejs npm

# Set working directory
WORKDIR /app

# Install Composer wajib 
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Strategi cache : install vendor dulu berdasarkan composer.json & composer.lock
COPY composer.json composer.lock ./
RUN composer install --no-dev --no-scripts --prefer-dist --no-autoloader

# Copy seluruh code dan lakukan dump-autoload
COPY . .
RUN composer dump-autoload --optimize

# ==========================================
# STAGE 2: Production (Hasil Akhir)
# ==========================================

# Gunakan image PHP 8.3 dengan FPM berbasis Alpine untuk hasil akhir
FROM php:8.3-fpm-alpine

# Set working directory
WORKDIR /var/www/html/selaksa-app

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Install library sistem yang dibutuhkan PHP di runtime
RUN apk add --no-cache libpng libxml2 libzip oniguruma nodejs npm

# Install extension PHP yang wajib ada di runtime minimalis saja
# Instal alat masak (build-deps), masak extension, lalu hapus alatnya
# Gunakan $PHPIZE_DEPS untuk mendapatkan alat compile standar PHP
RUN apk add --no-cache --virtual .build-deps $PHPIZE_DEPS \
    libpng-dev libxml2-dev libzip-dev oniguruma-dev \
    && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd \
    && apk del .build-deps

# Kunci multi-stage: Copy hasil build dari stage sebelumnya (builder)
# Hanya ambil source code aplikasi dan vendor yang sudah di-optimize supaya ringan
COPY --from=builder /app/vendor ./vendor
COPY --from=builder /app .

# Atur permission Laravel
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Jalankan PHP-FPM sebagai user www-data untuk keamanan
USER www-data

# Expose port 9000 dan jalankan PHP-FPM
EXPOSE 9000

# Eksekusi PHP-FPM
CMD ["php-fpm"]

# Catatan:

# Keamanan Ekstrem: Di stage final, tidak ada git atau composer. 
# Jika hacker berhasil masuk ke container, mereka tidak bisa dengan mudah melakukan git pull atau merusak library karena alat-alatnya tidak ada.

# Ukuran Image Sangat Kecil: Image kamu tidak akan membawa sampah-sampah cache dari perintah apk add atau cache composer yang besar.

# Efisiensi Layer: Docker hanya perlu menyimpan layer kecil di stage terakhir. 
# Ini mempercepat proses deployment ke server seperti AWS atau Google Cloud.


# ==========================================    
# VERSI LAMA TANPA MULTI-STAGE BUILD (DITINGGALKAN)
# ==========================================

# # Menggunakan image PHP 8.3 dengan FPM berbasis Alpine agar ringan
# FROM php:8.3-fpm-alpine

# # Install dependency PHP yang dibutuhkan Laravel
# RUN apk add --no-cache \
#     zip unzip git curl libpng-dev libonig-dev libxml2-dev libzip-dev \
#     && docker-php-ext-install pdo pdo_mysql mbstring exif pcntl bcmath gd

# # Set working directory
# WORKDIR /var/www/html/selaksa-app

# # Install composer dulu
# COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# # Copy file composer.json dan composer.lock ke container
# COPY composer.json composer.lock ./

# # Jalankan installasi dependency menggunakan Composer
# RUN composer install --no-dev --no-scripts --prefer-dist --no-autoloader

# # Copy project ke container
# COPY . .

# # Layer jalankan autoload  dan atur Permission Laravel
# RUN composer dump-autoload --optimize \
#     && chown -R www-data:www-data /var/www/html/selaksa-app/storage /var/www/html/selaksa-app/bootstrap/cache \
#     && chmod -R 775 storage bootstrap/cache

# CMD ["php-fpm"]
