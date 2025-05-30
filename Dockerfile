FROM php:8.3.14-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    libzip-dev \
    libpq-dev \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install zip pdo_mysql pdo_pgsql

# Enable Apache rewrite module
RUN a2enmod rewrite

# Copy application code to Apache root
COPY . /var/www/html/

# Change Apache document root to Laravel's public folder
RUN sed -i 's|/var/www/html|/var/www/html/public|g' /etc/apache2/sites-available/000-default.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# Install dependencies, optimize autoloader, no dev packages
RUN composer install --optimize-autoloader --no-dev

# Set permissions for storage and cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache /var/www/html/public

# Clear config and cache to avoid stale config issues
RUN php artisan config:clear && php artisan cache:clear && php artisan route:clear && php artisan view:clear

# Run migrations (without --columns or extra options)
RUN php artisan migrate --force

# Expose HTTP port
EXPOSE 80
