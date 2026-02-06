##################### COMMON COMMANDS
up:
	docker compose up -d

down:
	docker compose down --remove-orphans

build:
	docker compose build --no-cache

build-cache:
	docker compose build

clear-logs:
	rm ./storage/logs/laravel.log

bash:
	docker compose exec php bash

optimize:
	docker compose exec php php artisan cache:clear
	docker compose exec php php artisan config:clear
	docker compose exec php php artisan route:clear
	docker compose exec php php artisan view:clear
	docker compose exec php php artisan optimize

## Выполнять команду вручную, ибо не срабатывает вот эта запись: (date "+%d_%m_%+_%H_%M")
dump-database:
	docker compose exec mysql mysqldump -uroot -proot app > ./backups/backup_$(date "+%d_%m_%Y_%H_%M").sql

drop-database:
	docker compose exec mysql mysql -uroot -proot -e "drop database if exists app; create database app"

chown:
	docker compose exec php chown -R www-data /var/www/storage
	docker compose exec php chmod -R 755 /var/www/storage

###################### BACKEND COMMANDS

# Integration tests
run-tests: pre-tests
	docker compose exec mysql mysql -uroot -proot -e "drop database if exists app; create database app"  && \
 	docker compose exec php php artisan cache:clear && \
 	docker compose exec php php artisan permission:cache-reset && \
 	docker compose exec php php artisan migrate --seed --env=tests && \
 	docker compose exec php php artisan test --env=tests

# Running commands before run tests
pre-tests:
	docker compose exec php php artisan key:generate --env=tests

key-generate:
	docker compose exec php php artisan key:generate

laravel-route:
	docker compose exec php php artisan route:cache

routes:
	docker compose exec php php artisan route:list

laravel-cache:
	docker compose exec php php artisan cache:clear

migrate:
	docker compose exec php php artisan migrate --force

migrate-seed:
	docker compose exec php php artisan migrate --seed

storage-link:
	docker compose exec php php artisan storage:link --force

composer-dev-install:
	docker compose exec php composer install

composer-prod-install:
	docker compose exec php composer install --no-dev --no-interaction --prefer-dist --optimize-autoloader

dump:
	docker compose exec php composer dumpautoload

tests:
	docker compose exec php vendor/bin/phpunit

queue:
	docker compose exec php php artisan queue:work

laravel-down:
	docker compose exec php php artisan down

laravel-up:
	docker compose exec php php artisan up

######################## FRONTEND COMMANDS
npm-install:
	docker compose exec -T node npm ci

build-production: npm-install
	docker compose exec -T node npm run build

npm-start:
	docker compose exec node npm run start

dev:
	docker compose exec node npm run dev
