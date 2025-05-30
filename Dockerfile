FROM php:8.3.14-apache

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev

# PHP extensions
RUN docker-php-ext-install zip pdo_mysql

# Enable Apache mod_rewrite (needed by Laravel)
RUN a2enmod rewrite

# Copy app files
COPY . /var/www/html/

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Install Laravel dependencies optimized for production
RUN composer install --optimize-autoloader --no-dev

# Adjust permissions
RUN chown -R www-data:www-data storage bootstrap/cache

# Expose the default Apache port
EXPOSE 80
