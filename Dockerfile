FROM php:8.1-fpm

RUN apt-get update && apt-get install -y \
    libzip-dev \
    unzip \
    && docker-php-ext-install zip pdo pdo_mysql

WORKDIR /var/www/html
COPY . .

RUN chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache
