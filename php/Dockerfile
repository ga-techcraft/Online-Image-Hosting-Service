# PHP Dockerfile for Apache (optional with extensions)
# This example uses php-fpm
FROM php:8.1-fpm

# Install extensions and dependencies
RUN docker-php-ext-install pdo pdo_mysql

WORKDIR /var/www/html