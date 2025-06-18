FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install basic PHP extensions
RUN docker-php-ext-install pdo pdo_mysql

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy composer files
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

# Copy application files
COPY . .

# Set environment variables
ENV APP_NAME=Laravel \
    APP_ENV=production \
    APP_DEBUG=false \
    APP_KEY=base64:jzSpzB41JT1dho0GqrToBdkneaPYUNQSMUxtNkRXyf0= \
    APP_URL=https://car-a31z.onrender.com \
    LOG_CHANNEL=stderr \
    DB_CONNECTION=mysql \
    DB_HOST=sql3.freesqldatabase.com \
    DB_PORT=3306 \
    DB_DATABASE=sql3785369 \
    DB_USERNAME=sql3785369 \
    DB_PASSWORD=QSrpQBp3bx

# Create .env file
RUN echo "APP_ENV=production" > .env

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Generate key
RUN php artisan key:generate --force

# Clear caches
RUN php artisan config:clear

# Expose port
EXPOSE 8000

# Start server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]