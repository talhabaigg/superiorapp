# Use the official PHP image as the base image (PHP 8.2 FPM)
FROM php:8.2-fpm

# Set working directory
WORKDIR /var/www

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    unzip \
    nodejs \
    npm

# Install PHP extensions
RUN docker-php-ext-install pdo mbstring exif pcntl bcmath gd

# Install Composer
COPY --from=composer:2.3 /usr/bin/composer /usr/bin/composer

# Copy existing application directory contents
COPY . /var/www

# Create a copy of .env.example as .env
# RUN cp .env.example .env

# Install PHP dependencies via Composer
RUN composer install --optimize-autoloader --no-dev

RUN php artisan config:clear
RUN php artisan cache:clear
RUN php artisan route:clear
# Install NPM dependencies for Vue.js
RUN npm install && npm run build

# Set correct permissions
RUN chown -R www-data:www-data /var/www

# Expose port 9000 for PHP-FPM
EXPOSE 9000

# Start PHP-FPM server
CMD ["php-fpm"]
