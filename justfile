dockerComposeDev := "docker compose -f docker-compose.development.yml"
dockerComposeProd := "docker compose -f docker-compose.production.yml"

test:
    {{dockerComposeDev}} run php-fpm /var/www/vendor/bin/phpunit -c /var/www/phpunit.xml

lint:
    {{dockerComposeDev}} run php-fpm /var/www/vendor/bin/phpmd /var/www/src text /var/www/phpmd.xml
    {{dockerComposeDev}} run php-fpm /var/www/vendor/bin/phpcs --standard=/var/www/phpcs.xml /var/www/src

start:
    {{dockerComposeDev}} up

stop:
    {{dockerComposeDev}} down

restart:
    {{dockerComposeDev}} down
    {{dockerComposeDev}} up

build:
    {{dockerComposeDev}} build

start-prod:
    {{dockerComposeProd}} up

stop-prod:
    {{dockerComposeProd}} down

restart-prod:
    {{dockerComposeProd}} down
    {{dockerComposeProd}} up

build-prod:
    {{dockerComposeProd}} build
