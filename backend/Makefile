.PHONY: install run migrate rollback fresh

install:
	composer install
	cp .env.example .env
	php artisan key:generate
	npm run dev && npm run build
run:
	php artisan serve --port=8000

migrate:
	php artisan migrate

rollback:
	php artisan migrate:rollback

fresh:
	php artisan migrate:fresh
	php artisan db:seed
	php artisan db:seed --class="AdminSeeder"

