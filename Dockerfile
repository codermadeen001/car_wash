FROM php:8.2-cli

# Install system dependencies and GD extension dependencies
RUN apt-get update && apt-get install -y \
    git unzip curl zip libzip-dev libpng-dev libjpeg62-turbo-dev libfreetype6-dev libonig-dev libxml2-dev

# Install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql zip gd

# Set working directory
WORKDIR /var/www

# Copy only composer files for caching
COPY composer.json composer.lock ./

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Run Composer install
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Copy the full Laravel project
COPY . .

# Set permissions
RUN chmod -R 755 /var/www

# Expose Laravel port
EXPOSE 8000

# Start Laravel dev server
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
