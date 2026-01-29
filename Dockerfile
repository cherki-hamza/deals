FROM php:8.2-apache

# --------------------------------------------------
# Enable Apache modules
# --------------------------------------------------
RUN a2enmod rewrite headers

# --------------------------------------------------
# System dependencies
# --------------------------------------------------
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    curl \
    nodejs \
    npm \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libonig-dev \
    libxml2-dev \
    libzip-dev \
    libexif-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install \
    pdo_mysql \
    mbstring \
    zip \
    gd \
    exif \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# --------------------------------------------------
# Install Composer
# --------------------------------------------------
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# --------------------------------------------------
# Set working directory
# --------------------------------------------------
WORKDIR /var/www/html

# --------------------------------------------------
# Copy project files
# --------------------------------------------------
COPY . .

# --------------------------------------------------
# Install PHP dependencies
# --------------------------------------------------
RUN composer install \
    --no-dev \
    --optimize-autoloader \
    --no-interaction \
    --prefer-dist

# --------------------------------------------------
# Build Vite assets
# --------------------------------------------------
RUN npm install && npm run build

# --------------------------------------------------
# Laravel storage & permissions
# --------------------------------------------------
RUN mkdir -p storage/app/public \
    && php artisan storage:link || true \
    && chown -R www-data:www-data storage bootstrap/cache public \
    && chmod -R 775 storage bootstrap/cache public

# --------------------------------------------------
# Apache document root → /public
# --------------------------------------------------
RUN sed -i 's|/var/www/html|/var/www/html/public|g' \
    /etc/apache2/sites-available/000-default.conf

# --------------------------------------------------
# Expose port
# --------------------------------------------------
EXPOSE 80