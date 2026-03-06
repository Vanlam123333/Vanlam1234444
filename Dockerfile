FROM php:8.2-apache

# Install SQLite3 system libraries first
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    && rm -rf /var/lib/apt/lists/*

# Enable PHP SQLite extensions
RUN docker-php-ext-install pdo pdo_sqlite

# Copy files
COPY . /var/www/html/

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html

EXPOSE 80
