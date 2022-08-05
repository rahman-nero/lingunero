##################### COMMON COMMANDS
docker-up:
	docker-compose up -d

docker-down:
	docker-compose down

docker-build: memory
	docker-compose up --build -d

clear-logs:
	rm ./storage/logs/laravel.log

memory:
	sudo sysctl -w vm.max_map_count=262144

## Выполнять команду вручную, ибо не срабатывает вот эта запись: (date "+%d_%m_%+_%H_%M")
dump-database:
	docker-compose exec mysql mysqldump -uroot -proot app > ./backups/backup_$(date "+%d_%m_%Y_%H_%M").sql

drop-database:
	docker-compose exec mysql mysql -uroot -proot -e "drop database if exists app; create database app"

chown:
	docker-compose exec php-fpm chown -R www-data /var/www/storage
	docker-compose exec php-fpm chmod -R 755 /var/www/storage

###################### BACKEND COMMANDS

# Integration tests
run-tests: pre-tests
	docker-compose exec mysql mysql -uroot -proot -e "drop database if exists app; create database app"  && \
 	docker-compose exec php-cli php artisan cache:clear && \
 	docker-compose exec php-cli php artisan permission:cache-reset && \
 	docker-compose exec php-cli php artisan migrate --seed --env=tests && \
 	docker-compose exec php-cli php artisan test --env=tests

# Running commands before run tests
pre-tests:
	docker-compose exec php-cli php artisan key:generate --env=tests

laravel-route:
	docker-compose exec php-cli php artisan route:cache

laravel-cache:
	docker-compose exec php-cli php artisan cache:clear

laravel-migrate:
	docker-compose exec php-cli php artisan migrate

laravel-migrate-seed:
	docker-compose exec php-cli php artisan migrate --seed

laravel-storage-link:
	docker-compose exec php-cli php artisan storage:link

composer-dev-install:
	docker-compose exec php-cli composer install

composer-prod-install:
	docker-compose exec php-cli composer install --no-dev

dump:
	docker-compose exec php-cli composer dumpautoload

laravel-tests:
	docker-compose exec php-cli vendor/bin/phpunit

laravel-queue:
	docker-compose exec php-cli php artisan queue:work

laravel-down:
	docker-compose exec php-cli php artisan down

laravel-up:
	docker-compose exec php-cli php artisan up

######################## FRONTEND COMMANDS
npm-install:
	docker-compose exec -T npm npm install

build-production: yarn-install
	docker-compose exec -T npm npm run build production

npm-start:
	docker-compose exec npm npm run start

mix-watch:
	docker-compose exec npm npm run watch
