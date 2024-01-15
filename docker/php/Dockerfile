FROM php8.3-fpm-alpine
WORKDIR /var/www/html
RUN chown -R 33:33 /var/www/html # UID for the user 'www-data'
RUN docker-php-ext-install pdo pdo_mysql
COPY ./docker/php/php.ini /usr/local/etc/php/conf.d/custom.php.ini