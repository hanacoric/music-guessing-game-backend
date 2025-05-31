FROM php:8.3-apache

# Install system dependencies and PHP extensions needed for Laravel and MySQL
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    && docker-php-ext-install zip pdo_mysql

# Enable Apache mod_rewrite (needed for Laravel routes)
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy application code to container
COPY . .

# Install composer dependencies (no dev)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
RUN composer install --optimize-autoloader --no-dev

# Fix permissions so Laravel can write cache and logs
RUN chown -R www-data:www-data storage bootstrap/cache public

# Change Apache DocumentRoot to Laravel public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

EXPOSE 80

# Run Apache in foreground (default command)
CMD ["apache2-foreground"]
