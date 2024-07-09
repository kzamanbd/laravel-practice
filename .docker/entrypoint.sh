#!/bin/bash

if [ ! -f "vendor/autoload.php" ]; then
    echo "Installing composer dependencies"
    composer install --no-progress --no-interaction
fi

if [ ! -f ".env" ]; then
    echo "Creating env file for env $APP_ENV"
    cp .env.example .env
else
    echo "env file exists."
fi

php-fpm
