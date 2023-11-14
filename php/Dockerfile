FROM php:8.1-fpm

ENV PATH="/usr/local/bin:${PATH}"

RUN apt-get update && apt-get install -y zlib1g-dev g++ git libicu-dev zip libzip-dev zip \
    && docker-php-ext-install intl opcache \
    && pecl install apcu \
    && docker-php-ext-enable apcu \
    && docker-php-ext-configure zip \
    && docker-php-ext-install zip \
    && docker-php-ext-install opcache

# Установка драйвера PDO MySQL
RUN apt-get install -y default-mysql-client \
    && docker-php-ext-install pdo pdo_mysql

COPY php.ini /usr/local/etc/php/conf.d/docker-php-ext-pdo_mysql.ini

WORKDIR /var/www/html

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN curl -sS https://get.symfony.com/cli/installer | bash

