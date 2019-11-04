install:
	composer install && npm i && php artisan migrate:refresh --seed

start:
	docker-compose up --build

watch:
	npm run watch

stop:
	docker-compose down

serve:
	php artisan serve

share:
	valet start && valet share

test:
	vendor/bin/phpunit
