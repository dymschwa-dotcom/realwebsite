# 1. Use an official PHP image with Apache
FROM php:8.3-apache

# 2. Update package list and install libraries
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libfreetype6-dev libzip-dev \
    libonig-dev libicu-dev zip unzip curl

# 3. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# 4. Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) mysqli pdo pdo_mysql gd zip bcmath mbstring intl

# 5. Enable 'mod_rewrite'
RUN a2enmod rewrite

# 6. Copy your local website files
COPY ./public_html /var/www/html/

# 7. Create the placeholder .env and installed lock
RUN cp /var/www/html/core/.env.example /var/www/html/core/.env \
    && touch /var/www/html/core/storage/installed

# 8. Set the correct permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/core/storage \
    && chmod -R 775 /var/www/html/core/bootstrap/cache \
    && mkdir -p /var/www/html/core/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer \
    && chown -R www-data:www-data /var/www/html/core/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer \
    && chmod -R 775 /var/www/html/core/vendor/ezyang/htmlpurifier/library/HTMLPurifier/DefinitionCache/Serializer \
    && chown www-data:www-data /var/www/html/core/.env

# 9. Set working directory to where composer.json lives
WORKDIR /var/www/html/core

# 10. Install dependencies (Added --no-scripts to prevent build crashes)
RUN composer install --no-interaction --optimize-autoloader --no-dev --no-scripts

# 11. Final setup
WORKDIR /var/www/html

