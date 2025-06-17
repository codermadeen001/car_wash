FROM php:8.2-cli

# Install dependencies
RUN apt-get update && apt-get install -y git unzip curl libzip-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Set working dir
WORKDIR /var/www

# Copy app
COPY . .

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set permissions
RUN chmod -R 755 /var/www && composer install

# Expose port
EXPOSE 8000

# Start Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
