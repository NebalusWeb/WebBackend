FROM php:8.3-fpm-alpine AS base
WORKDIR /code-repo
RUN chown -R www-data:www-data . # UID for the user 'www-data'
RUN docker-php-ext-install pdo pdo_mysql
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.php.ini
