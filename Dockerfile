# 1. Use an official PHP image with Apache (standard for cPanel)
FROM php:8.3-apache

# 2. Update package list and install libraries
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libicu-dev \
    zip \
    unzip \
    curl

# 3. Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
# 4. Configure and install PHP extensions
RUN docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install -j$(nproc) \
    mysqli \
    pdo \
    pdo_mysql \
    gd \
    zip \
    bcmath \
    mbstring \
    intl

# 5. Enable 'mod_rewrite' (this is what makes "pretty" URLs and .htaccess work)
RUN a2enmod rewrite

# 6. Copy your local website files into the web server's folder inside Docker
COPY ./public_html /var/www/html/

# 7. Set the correct permissions for Laravel/PHP
# In cPanel, permissions are often loose. In Docker, we need precision.
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 /var/www/html/core/storage \
    && chmod -R 775 /var/www/html/core/bootstrap/cache

# 8. Set working directory
WORKDIR /var/www/html/core

# 9. Install Composer dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# 10. Final setup
WORKDIR /var/www/html

#