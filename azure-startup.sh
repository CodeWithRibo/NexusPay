#!/bin/bash
# startup.sh for Laravel on Azure

# Copy configs if present
[ -f /home/site/wwwroot/default ] && cp /home/site/wwwroot/default /etc/nginx/sites-enabled/default
[ -f /home/site/wwwroot/php.ini ] && cp /home/site/wwwroot/php.ini /usr/local/etc/php/conf.d/php.ini

# Install GD + Supervisor
apt-get update --allow-releaseinfo-change
apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev libwebp-dev supervisor
docker-php-ext-configure gd --with-freetype --with-webp --with-jpeg
docker-php-ext-install gd

# Supervisor worker config
[ -f /home/laravel-worker.conf ] && cp /home/laravel-worker.conf /etc/supervisor/conf.d/laravel-worker.conf

service nginx restart
service supervisor restart

# Laravel setup
cd /home/site/wwwroot

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

php artisan down --refresh=15 --secret="1630542a-246b-4b66-afa1-dd72a4c43515"
php artisan migrate --force
php artisan cache:clear
php artisan route:cache
php artisan config:cache
php artisan view:cache
# php artisan storage:link   # uncomment if needed
php artisan up

# Optional: build frontend assets
# npm ci
# npm run production --silent

# Optional: run queue worker
# nohup php artisan queue:work &
