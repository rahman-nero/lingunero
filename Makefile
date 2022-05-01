route:
	docker-compose exec php-cli php artisan route:cache

php-migrate:
	docker-compose exec php-cli php artisan migrate

composer:
	docker-compose exec php-cli composer install

npm:
	docker-compose exec npm npm install

docker-up: memory
	docker-compose up -d

docker-down:
	docker-compose down

docker-build: memory
	docker-compose up --build -d

test:
	docker-compose exec php-cli vendor/bin/phpunit

queue:
	docker-compose exec php-cli php artisan queue:work

memory:
	sudo sysctl -w vm.max_map_count=262144
