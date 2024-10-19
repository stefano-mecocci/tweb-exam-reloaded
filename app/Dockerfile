FROM php:8.3-fpm

RUN mkdir -p /var/www/html/src

RUN docker-php-ext-install pdo pdo_mysql

RUN pecl install xdebug 

RUN chown -R www-data:www-data /var/www/html
