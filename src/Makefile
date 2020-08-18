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
	php artisan storage:link

start:
	php artisan serve

autoload:
	composer dump-autoload

route:
	php artisan route:list