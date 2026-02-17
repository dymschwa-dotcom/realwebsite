# 1. Use an official PHP image with Apache (standard for cPanel)
FROM php:8.3-apache

# 2. Install the MySQL extensions so your site can talk to its database
RUN docker-php-ext-install mysqli pdo pdo_mysql

# 3. Enable 'mod_rewrite' (this is what makes "pretty" URLs and .htaccess work)
RUN a2enmod rewrite

# 4. Copy your local website files into the web server's folder inside Docker
COPY ./public_html /var/www/html/

# 5. Set the correct permissions so Apache can read your files
RUN chown -R www-data:www-data /var/www/html
RUN chmod -R 755 /var/www/html