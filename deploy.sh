#!/bin/bash

# cPanel Deployment Script for Laravel
# Run this after git pull

cd /home/username/laravel

# Install/update dependencies
/usr/local/bin/php /usr/local/bin/composer install --no-dev --optimize-autoloader

# Clear and cache config
/usr/local/bin/php artisan config:clear
/usr/local/bin/php artisan config:cache

# Clear and cache routes
/usr/local/bin/php artisan route:clear
/usr/local/bin/php artisan route:cache

# Clear and cache views
/usr/local/bin/php artisan view:clear
/usr/local/bin/php artisan view:cache

# Run migrations (optional - be careful in production)
# /usr/local/bin/php artisan migrate --force

# Set permissions
chmod -R 775 storage
chmod -R 775 bootstrap/cache

echo "Deployment completed successfully!"
