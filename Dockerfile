FROM php:8.3.14-apache

# Install required dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev

# Install necessary PHP extensions
RUN docker-php-ext-install zip pdo_mysql pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files
COPY . /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install Laravel dependencies
RUN composer install --optimize-autoloader --no-dev

# Set correct permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Run migrations automatically during build
RUN php artisan migrate --force

EXPOSE 80
