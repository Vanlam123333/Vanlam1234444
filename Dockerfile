FROM php:8.2-apache

# Enable SQLite
RUN docker-php-ext-install pdo pdo_sqlite

# Copy files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
