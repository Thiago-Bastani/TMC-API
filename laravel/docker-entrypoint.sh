#!/bin/sh
set -e

# Wait for PostgreSQL to be ready
echo "Waiting for database..."
until php -r "new PDO('pgsql:host=${DB_HOST};port=${DB_PORT};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}');" 2>/dev/null; do
  sleep 2
done
echo "Database ready."

# Run migrations
php artisan migrate --force

# Create Supabase storage bucket (idempotent)
php artisan db:seed --force

# Start php-fpm
exec php-fpm
