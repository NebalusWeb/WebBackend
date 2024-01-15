FROM nginx:1.25.3-alpine
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/html
RUN chown -R 33:33 . # UID for the user 'www-data'
