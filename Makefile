ps:
	cd laradock; docker-compose ps

restart:
	make stop
	make start

start:
	cd laradock; docker-compose up -d workspace nginx mysql redis laravel-echo-server

stop:
	cd laradock; docker-compose down

build:
	cd laradock; docker-compose build workspace nginx mysql redis laravel-echo-server

exec:
	cd laradock; docker-compose exec workspace bash

exec_mysql:
	cd laradock; docker-compose exec mysql bash
