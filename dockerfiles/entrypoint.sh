#!/bin/bash

# Wait for MySQL to be ready
echo "Waiting for MySQL..."
while ! nc -z db 3306; do
    sleep 1
done

# Install composer dependencies
echo "Installing composer dependencies..."
composer install

# Run migrations and seed the database
echo "Running migrations and seeding the database..."
php artisan migrate --seed

# Start PHP-FPM
echo "Starting PHP-FPM..."
php-fpm
