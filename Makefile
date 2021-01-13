i:
	composer i && make dbs && npm i && make w

ri:
	make cc && make rm && make i

rm:
	rm -rf vendor && rm -rf node_modules && rm -rf bootstrap/cache/packages.php && rm -rf bootstrap/cache/services.php && rm -rf bootstrap/cache/config.php && rm -rf public/dist && rm -rf mix-manifest.json

w:
	npm run watch

dbs:
	php artisan migrate:fresh --seed

cc:
	php artisan clear && php artisan view:clear && php artisan cache:clear && php artisan config:cache && make cda

cda:
	composer dump-autoload

test:
	vendor/bin/phpunit

share:
	valet start && valet share
