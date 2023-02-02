init: docker-down docker-pull docker-build docker-up
up: docker-up
down: docker-down
restart: docker-down docker-up


##################### COMMON COMMANDS
docker-up:
	docker-compose up -d

docker-pull:
	docker-compose pull

docker-down:
	docker-compose down --remove-orphans

docker-build: memory
	docker-compose build --pull

memory:
	sudo sysctl -w vm.max_map_count=262144


build: build-gateway build-frontend-nginx  build-backend-nginx build-backend-php-fpm

build-gateway:
	docker --log-level=debug build --pull --file=docker/production/gateway/Dockerfile --tag=${REGISTRY}/english-gateway:${IMAGE_TAG} docker/production/gateway

build-frontend-nginx:
	docker --log-level=debug build --pull --file=frontend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/english-frontend-nginx:${IMAGE_TAG} frontend

build-backend-nginx:
	docker --log-level=debug build --pull --file=backend/docker/production/nginx/Dockerfile --tag=${REGISTRY}/english-backend-nginx:${IMAGE_TAG} backend

build-backend-php-fpm:
	docker --log-level=debug build --pull --file=backend/docker/production/php-fpm/Dockerfile --tag=${REGISTRY}/english-backend-php-fpm:${IMAGE_TAG} backend

try-build:
	REGISTRY=localhost IMAGE_TAG=1 make build


push: push-gateway push-backend-nginx  push-backend-php-fpm push-frontend-nginx

push-gateway:
	docker push ${REGISTRY}/english-gateway:${IMAGE_TAG}

push-frontend-nginx:
	docker push ${REGISTRY}/english-frontend-nginx:${IMAGE_TAG}

push-backend-nginx:
	docker push ${REGISTRY}/english-backend-nginx:${IMAGE_TAG}

push-backend-php-fpm:
	docker push ${REGISTRY}/english-backend-php-fpm:${IMAGE_TAG}

deploy:
	  ssh ${HOST} -p ${PORT} 'rm -rf site_${BUILD_NUMBER}' && \
      ssh ${HOST} -p ${PORT} 'mkdir site_${BUILD_NUMBER}'  && \
      scp -P ${PORT} docker-compose-production.yml ${HOST}:site_${BUILD_NUMBER}/docker-compose-production.yml  && \
      ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "COMPOSE_PROJECT_NAME=english" >> .env'  && \
      ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "REGISTRY=${REGISTRY}" >> .env'  && \
      ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && echo "IMAGE_TAG=${IMAGE_TAG}" >> .env'  && \
      ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml pull'  && \
      ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml up -d --build --remove-orphans'  && \
      ssh ${HOST} -p ${PORT} 'rm -f site'  && \
      ssh ${HOST} -p ${PORT} 'ln -sr site_${BUILD_NUMBER} site'

rollback:
	  ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml pull'  && \
      ssh ${HOST} -p ${PORT} 'cd site_${BUILD_NUMBER} && docker-compose -f docker-compose-production.yml up -d --build --remove-orphans'  && \
      ssh ${HOST} -p ${PORT} 'rm -f site'  && \
      ssh ${HOST} -p ${PORT} 'ln -sr site_${BUILD_NUMBER} site'


###################### BACKEND COMMANDS

## Выполнять команду вручную, ибо не срабатывает вот эта запись: (date "+%d_%m_%+_%H_%M")
dump-database:
	docker-compose exec  mysqldump -uroot -proot app > ./backups/backup_$(date "+%d_%m_%Y_%H_%M").sql

drop-database:
	docker-compose exec backend-mysql mysql -uroot -proot -e "drop database if exists app; create database app"

chown:
	docker-compose exec backend-php-fpm chown -R www-data /var/www/storage
	docker-compose exec backend-php-fpm chmod -R 755 /var/www/storage

# Integration tests
run-tests: pre-tests
	docker-compose exec backend-mysql mysql -uroot -proot -e "drop database if exists app; create database app"  && \
 	docker-compose exec backend-php-cli php artisan cache:clear && \
 	docker-compose exec backend-php-cli php artisan permission:cache-reset && \
 	docker-compose exec backend-php-cli php artisan migrate --seed --env=tests && \
 	docker-compose exec backend-php-cli php artisan test --env=tests

# Running commands before run tests
pre-tests:
	docker-compose exec backend-php-cli php artisan key:generate --env=tests

laravel-route:
	docker-compose exec backend-php-cli php artisan route:cache

laravel-cache:
	docker-compose exec backend-php-cli php artisan cache:clear

laravel-migrate:
	docker-compose exec backend-php-cli php artisan migrate

laravel-migrate-seed:
	docker-compose exec backend-php-cli php artisan migrate --seed

laravel-storage-link:
	docker-compose exec backend-php-cli php artisan storage:link

laravel-key-generate:
	docker-compose exec backend-php-cli php artisan key:generate

composer-dev-install:
	docker-compose exec backend-php-cli composer install

composer-prod-install:
	docker-compose exec backend-php-cli composer install --no-dev

dump:
	docker-compose exec backend-php-cli composer dumpautoload

laravel-tests:
	docker-compose exec backend-php-cli vendor/bin/phpunit

laravel-queue:
	docker-compose exec backend-php-cli php artisan queue:work

laravel-down:
	docker-compose exec backend-php-cli php artisan down

laravel-up:
	docker-compose exec backend-php-cli php artisan up

psalm:
	docker-compose exec backend-php-cli ./vendor/bin/psalm --no-cache --show-info=true

######################## FRONTEND COMMANDS
npm-install:
	docker-compose exec -T frontend-npm npm install

build-production: npm-install
	docker-compose exec -T frontend-npm npm run build prod

npm-start:
	docker-compose exec frontend-npm npm  run start

mix-watch:
	docker-compose exec frontend-npm npm run watch

npm-eslint:
	docker-compose exec frontend-npm npx eslint ./src
