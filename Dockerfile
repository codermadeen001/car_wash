FROM php:8.2-apache

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libonig-dev libxml2-dev \
    libfreetype6-dev libjpeg62-turbo-dev libpq-dev postgresql-client \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) gd \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath zip opcache

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Set working directory
WORKDIR /var/www/html

# Copy only what's needed for composer install
COPY composer.json composer.lock ./

# Install dependencies
RUN composer install --no-dev --no-scripts --no-interaction --prefer-dist --ignore-platform-reqs

# Copy the rest of the application
COPY . .

# Clean up any old project references (critical for renamed projects)
RUN find . -type f -exec sed -i 's/realestateplatform//g' {} \; || true && \
    find . -name "*.php" -exec grep -l "realestate" {} \; -delete || true

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Create .env file if it doesn't exist
RUN if [ ! -f .env ]; then cp .env.example .env; fi

# Add PostgreSQL SSL certificate
RUN mkdir -p /etc/ssl/certs/ && \
    curl -o /etc/ssl/certs/rds-combined-ca-bundle.pem https://truststore.pki.rds.amazonaws.com/rds-combined-ca-bundle.pem

# Complete cache purge and rebuild
RUN php artisan optimize:clear && \
    rm -rf bootstrap/cache/* && \
    rm -rf storage/framework/cache/* && \
    rm -rf storage/framework/views/* && \
    composer dump-autoload --optimize

# Run composer scripts
RUN composer dump-autoload --optimize --classmap-authoritative && \
    php artisan package:discover --ansi && \
    php artisan key:generate --force

# Database preparation
RUN php artisan config:clear && \
    php artisan cache:clear && \
    php artisan view:clear

# Health check
HEALTHCHECK --interval=30s --timeout=3s \
  CMD curl -f http://localhost:8000/health || exit 1

# Expose port
EXPOSE 8000

# Start server with clean cache and migrations
CMD ["sh", "-c", "php artisan config:clear && php artisan cache:clear && php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=8000"]