FROM nginx:stable AS base
COPY ./docker/nginx/default.conf /etc/nginx/conf.d/default.conf
WORKDIR /var/www/
RUN chown -R www-data:www-data . # UID for the user 'www-data'

FROM base AS development
# Nothing

FROM base AS production
COPY ./public ./public
