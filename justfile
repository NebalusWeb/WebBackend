dockerComposeDev := "docker compose -f docker-compose.development.yml"
dockerComposeProd := "docker compose -f docker-compose.production.yml"

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
