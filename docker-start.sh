#!/bin/bash

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

# Start Apache
apache2-foreground
