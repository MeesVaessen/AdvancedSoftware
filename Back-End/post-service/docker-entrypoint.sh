#!/bin/bash
set -e

# Wait for MySQL to be ready (use the correct service name)
echo "Waiting for database connection..."
until nc -z -v -w30 $DB_HOST $DB_PORT; do
  echo "Waiting for MySQL..."
  sleep 5
done

echo "Database is ready!"

# Run Laravel commands after MySQL is up
php artisan migrate:fresh --seed
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start Laravel
exec "$@"

