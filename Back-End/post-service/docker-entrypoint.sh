#!/bin/bash
set -e
sleep 5
php artisan config:clear

php artisan key:generate --no-interaction
# Central migration
php artisan migrate --database=central --path=/database/migrations/Central --seed --force

# Shard migrations (assuming same path for both)
php artisan migrate --database=shard_1 --path=/database/migrations/Shard --seed --force
php artisan migrate --database=shard_2 --path=/database/migrations/Shard --seed --force

# Clear caches
php artisan cache:clear --no-interaction
php artisan config:clear --no-interaction
php artisan route:clear --no-interaction
php artisan view:clear --no-interaction

# Rebuild caches (best practice in production)
php artisan config:cache --no-interaction
php artisan route:cache --no-interaction
php artisan view:cache --no-interaction

# Boot Laravel Octane with FrankenPHP


# Start Laravel
exec php artisan octane:frankenphp --no-interaction
#exec "$@"
