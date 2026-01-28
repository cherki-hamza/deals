FROM php:8.2-fpm-alpine

# Install system deps
RUN apk add --no-cache \
    nginx \
    bash \
    curl \
    zip \
    unzip \
    libpng-dev \
    oniguruma-dev \
    icu-dev \
    libzip-dev

# PHP extensions
RUN docker-php-ext-install pdo pdo_mysql mbstring intl zip gd

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Nginx config
COPY docker/nginx.conf /etc/nginx/nginx.conf

EXPOSE 80

CMD ["sh", "-c", "php-fpm -D && nginx -g 'daemon off;'"]