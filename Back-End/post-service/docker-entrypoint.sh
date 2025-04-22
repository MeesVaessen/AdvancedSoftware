#!/bin/bash
set -e

# Wait for all DBs
echo "Waiting for central DB..."
until nc -z -v -w30 $DB_HOST $DB_PORT; do
  echo "Waiting for central DB..."
  sleep 5
done

echo "Waiting for shard1..."
until nc -z -v -w30 $DB_SHARD1_HOST 3306; do
  echo "Waiting for shard1 DB..."
  sleep 5
done

echo "Waiting for shard2..."
until nc -z -v -w30 $DB_SHARD2_HOST 3306; do
  echo "Waiting for shard2 DB..."
  sleep 5
done

echo "All databases are ready!"

# Central migration
php artisan migrate:fresh --database=central --path=/database/migrations/Central --seed --force

# Shard migrations (assuming same path for both)
php artisan migrate:fresh --database=shard_1 --path=/database/migrations/Shard --seed --force
php artisan migrate:fresh --database=shard_2 --path=/database/migrations/Shard --seed --force

# Clear caches
php artisan cache:clear
php artisan config:clear
php artisan route:clear
php artisan view:clear

# Start Laravel
exec "$@"
