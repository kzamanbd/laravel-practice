FROM php:8.3-fpm

# Set working directory
WORKDIR /var/www/html

# Arguments defined in docker-compose.yml
ARG user
ARG uid

# Install system dependencies
# Linux Library
RUN apt-get update -y && apt-get install -y \
    libicu-dev \
    libmariadb-dev \
    unzip zip \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    zlib1g-dev


# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql gettext intl gd zip exif

# redis
RUN pecl install redis && docker-php-ext-enable redis

RUN docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd

# Get latest Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy the existing application directory contents
COPY . /var/www/html

# Ensure the script files are executable
RUN chmod +x /var/www/html/docker/install-composer.sh

# Install PHP dependencies
RUN composer install --no-scripts --no-autoloader

# Copy the entrypoint script
COPY ./.docker/entrypoint.sh /usr/local/bin/

# Make the entrypoint script executable
RUN chmod +x /usr/local/bin/entrypoint.sh

# Create system user to run Composer and Artisan Commands
RUN useradd -G www-data,root -u $uid -d /home/$user $user
RUN mkdir -p /home/$user/.composer && \
    chown -R $user:$user /home/$user

USER $user

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]
