SAIL := ./vendor/bin/sail

up:
	$(SAIL) up -d

down:
	$(SAIL) down

migrate:
	$(SAIL) artisan migrate

mysql:
	$(SAIL) mysql
