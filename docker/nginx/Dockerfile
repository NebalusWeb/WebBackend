FROM nginx:stable AS base
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html
RUN chown -R www-data:www-data . # UID for the user 'www-data'
