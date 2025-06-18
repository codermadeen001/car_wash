FROM php:8.2-cli

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libjpeg62-turbo-dev \
    libfreetype6-dev libonig-dev libxml2-dev \
    libssl-dev pkg-config libcurl4-openssl-dev \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd mbstring tokenizer bcmath

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www

# Copy composer files first for better caching
COPY composer.json composer.lock ./

# Install dependencies (without dev dependencies for production)
RUN composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader --no-scripts

# Copy application files
COPY . .

# Set environment variables directly in Docker
ENV APP_NAME=Laravel \
    APP_ENV=production \
    APP_DEBUG=false \
    APP_KEY=base64:jzSpzB41JT1dho0GqrToBdkneaPYUNQSMUxtNkRXyf0= \
    APP_URL=https://car-a31z.onrender.com \
    LOG_CHANNEL=stderr \
    LOG_LEVEL=error \
    DB_CONNECTION=mysql \
    DB_HOST=sql3.freesqldatabase.com \
    DB_PORT=3306 \
    DB_DATABASE=sql3785369 \
    DB_USERNAME=sql3785369 \
    DB_PASSWORD=QSrpQBp3bx \
    BROADCAST_DRIVER=log \
    CACHE_DRIVER=file \
    FILESYSTEM_DISK=local \
    QUEUE_CONNECTION=sync \
    SESSION_DRIVER=file \
    SESSION_LIFETIME=120 \
    SESSION_DOMAIN=.onrender.com \
    SANCTUM_STATEFUL_DOMAINS=car-a31z.onrender.com,localhost \
    MAIL_MAILER=smtp \
    MAIL_HOST=smtp.gmail.com \
    MAIL_PORT=587 \
    MAIL_USERNAME=syeundainnocent@gmail.com \
    MAIL_PASSWORD=vwuergurzyjucjmc \
    MAIL_ENCRYPTION=tls \
    MAIL_FROM_ADDRESS=noreply@yourcarwash.com \
    MAIL_FROM_NAME="Auto Clean" \
    JWT_SECRET=JYXM3dcQQmmXZhONKMpQ9oLjK65LENpRKyJ3OpjYHVhLgZWebyoE3iG7Wu9Txsau \
    CLOUDINARY_URL=cloudinary://769447669581899:SMXcoOapJt4KElCoVzbCJ_SzIqM@dadcnkqbg

# Create complete .env file with hardcoded values
# Create a basic .env file (Laravel still expects this file to exist)
RUN echo "# Environment variables are set via Docker ENV" > .env

# Set proper permissions
RUN chown -R www-data:www-data /var/www \
    && chmod -R 755 /var/www \
    && chmod -R 775 storage bootstrap/cache

# Generate application key if not set by environment
RUN php artisan key:generate --force

# Clear caches and optimize for production
RUN php artisan config:clear \
    && php artisan route:clear \
    && php artisan view:clear \
    && php artisan cache:clear

# Cache config and routes for production (do this after environment variables are available)
# Note: We'll do this at runtime to ensure environment variables are loaded

# Final composer optimization
RUN composer dump-autoload --optimize

# Expose port
EXPOSE 8000

# Health check
HEALTHCHECK --interval=30s --timeout=3s --start-period=5s --retries=3 \
    CMD curl -f http://localhost:8000 || exit 1

# Start Laravel server with configuration caching at runtime
CMD php artisan config:cache && php artisan route:cache && php artisan view:cache && php artisan serve --host=0.0.0.0 --port=8000