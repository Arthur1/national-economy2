ps:
	cd laradock; docker-compose ps

restart:
	make stop
	make start

start:
	cd laradock; docker-compose up -d workspace nginx mysql php-worker

stop:
	cd laradock; docker-compose down

build:
	cd laradock; docker-compose build workspace nginx mysql php-worker

exec:
	cd laradock; docker-compose exec --user 1000 workspace bash

exec_mysql:
	cd laradock; docker-compose exec mysql bash
