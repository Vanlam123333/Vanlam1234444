FROM php:8.2-apache

# Install SQLite3 + curl (cần cho gọi Groq API)
RUN apt-get update && apt-get install -y \
    libsqlite3-dev \
    sqlite3 \
    libcurl4-openssl-dev \
    && docker-php-ext-install pdo pdo_sqlite curl \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Copy files
COPY . /var/www/html/

# Set permissions + tạo thư mục data cho SQLite
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod 777 /var/www/html

# Railway inject PORT, Apache phải listen đúng port đó
RUN sed -i 's/Listen 80/Listen ${PORT:-80}/' /etc/apache2/ports.conf \
    && sed -i 's/<VirtualHost \*:80>/<VirtualHost *:${PORT:-80}>/' /etc/apache2/sites-enabled/000-default.conf

EXPOSE 80
