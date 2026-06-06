#!/bin/bash

# Create .env from .env.example if it doesn't exist.
# Railway injects environment variables at runtime but does not write a .env
# file to disk, so php artisan key:generate (which reads/writes .env) would
# fail with "Failed to open stream: No such file or directory" without this.
if [ ! -f /var/www/html/.env ]; then
    cp /var/www/html/.env.example /var/www/html/.env
fi

# Generate app key if not set
php artisan key:generate --force

# Run migrations
php artisan migrate --force

# Create storage link (ignore error if already exists)
php artisan storage:link 2>/dev/null || true

# Clear and cache config
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start PHP-FPM in background
php-fpm &

# Start Nginx in foreground
nginx -g "daemon off;"

