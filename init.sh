#!/bin/sh

docker-compose up -d --build

docker exec catalog_php composer install
docker exec catalog_php php artisan migrate
docker exec catalog_php php artisan db:seed

docker exec catalog_php sh -c "cd /var/www/front && npm install"

cd ./front
npm run serve