ifndef env
env:=dev
endif

OS:=$(shell uname)

init-app:
	cp .env.example .env
	composer install
	php artisan key:generate
	php artisan migrate
	php artisan DB:seed
	npm install
	php artisan storage:link

start:
	php artisan serve

run-node:
	node server

autoload:
	composer dump-autoload

route:
	php artisan route:list

refresh-db:
	php artisan migrate:refresh
	php artisan DB:seed