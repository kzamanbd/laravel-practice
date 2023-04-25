# Path: .docker\nginx\Dockerfile

FROM php:8.1-fpm-alpine

# Install system dependencies
ENV PECL_EXTENSIONS = "pcov psr xdebug"
ENV PECL_EXTENSIONS ="bz2 gd exif gettext intl pcntl pdo_mysql zip"

RUN apk add --no-cache --virtual .build-deps \
    $PHPIZE_DEPS libtool \
    && apk add --no-cache bzip2-dev gettext-dev git icu icu-dev libintl libpng-dev libzip-dev mysql-client \
    # Install PECL extensions
    && docker-php-source extract \
    && pecl channel-update pecl.php.net \
    && pecl install $PECL_EXTENSIONS \
    && cd /usr/src/php/ext/ \
    && docker-php-ext-configure opcache --enable-opcache \
    # Install PHP extensions
    && docker-php-ext-install -j "$(nproc)" $PHP_EXTENSIONS \
    # clean up
    && apk del -f .build-deps \
    && cd /usr/local/etc/php/conf.d \
    && pecl clear-cache \
    && docker-php-source delete \
    && rm -rf /var/cache/apk/* /tmp/* /var/tmp/* /usr/share/doc/* /usr/share/man/*

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html
USER www-data

