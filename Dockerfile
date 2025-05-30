FROM php:8.3.14-apache

# Install system dependencies including PostgreSQL dev files
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpq-dev

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application files to the container
COPY . /var/www/html/

# Install Composer (from official composer image)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Install Laravel dependencies optimized for production
RUN composer install --optimize-autoloader --no-dev

# Set correct permissions for Laravel folders
RUN chown -R www-data:www-data storage bootstrap/cache

# Run Laravel migrations automatically (disable if you want to run manually)
RUN php artisan migrate --force

# Expose port 80 for Apache
EXPOSE 80
