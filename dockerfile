FROM php:8.3-cli

# Install system deps
RUN apt-get update && apt-get install -y \
    git unzip libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Install composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /app

# Copy project
COPY . .

# Install dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel permission
RUN chmod -R 777 storage bootstrap/cache

# Expose port Railway
EXPOSE 8000

# Run Laravel
CMD php artisan serve --host=0.0.0.0 --port=8000
