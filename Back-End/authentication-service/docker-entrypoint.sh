#!/bin/bash
set -e
sleep 5

if [ -z "$APP_KEY" ]; then
  php artisan key:generate
fi
php artisan migrate

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear
php artisan octane:frankenphp

# Start Laravel
exec "$@"
