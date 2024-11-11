FROM php:8.3.12-fpm-alpine AS base
WORKDIR /var/www/
RUN chown -R www-data:www-data .
RUN docker-php-ext-install pdo pdo_mysql
RUN apk add --no-cache php83-simplexml php83-fileinfo

FROM composer:latest AS composerinstaller
WORKDIR /composer
COPY ./composer.json .
RUN composer install

FROM base AS development
COPY ./docker/php-fpm/development.ini $PHP_INI_DIR/conf.d/custom.php.ini
RUN apk add --update linux-headers
RUN apk add --no-cache $PHPIZE_DEPS
RUN pecl install xdebug-3.3.1 && docker-php-ext-enable xdebug

FROM base AS production
COPY ./docker/php-fpm/production.ini $PHP_INI_DIR/conf.d/custom.php.ini
COPY ./src ./src
COPY ./public ./public
COPY --from=composerinstaller /composer/vendor ./vendor
