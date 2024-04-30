# vim:ft=make
# Makefile

DOCKER_EXEC = @docker-compose exec

ifneq (,$(wildcard ./.env))
    include .env
    export
endif

.PHONY:
.DEFAULT_GOAL := help

help:			## List all available commands
	@echo "Available commands:"
	@echo ""
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

up: 		## App DEV up environment
	@docker compose up -d
	@echo "    "
	@echo "    Dev Environment is started!"
	@echo "    "
	@echo "    Dev host http://localhost:$(BACKEND_PORT)"

build:		## Build app container
	docker compose build

logs:		## Show logs from app container
	docker compose logs -f

logs-calc: ## Show logs from calc container
	docker compose backend tail -f /app/log/dev-math-calculation.log

down:		## App DEV down environment
	docker compose down

dev-composer-install:	## Install composer things
	$(DOCKER_EXEC) backend php -d memory_limit=4G -d xdebug.remote_enable=0 -d COMPOSER_NO_DEV=0 /usr/local/bin/composer install

sh:		## Open CLI to backend container
	$(DOCKER_EXEC) backend bash

dev-migrate:		## Run migrations
	$(DOCKER_EXEC) backend php /app/bin/console doctrine:migrations:migrate --no-interaction

tests-run:		## Run tests
	$(DOCKER_EXEC) backend php /app/vendor/bin/codecept run Unit

app-tests-parse:		## Run App parse tests
	$(DOCKER_EXEC) backend php /app/bin/console app:tests-parse

app-tests-run:		## Run App parse run
	$(DOCKER_EXEC) backend php /app/bin/console app:tests-run

app-tests-history:		## Run App parse history
	$(DOCKER_EXEC) backend php /app/bin/console app:tests-history

app-tests-rewind:		## Run App parse tests
	$(DOCKER_EXEC) backend php /app/bin/console app:tests-rewind
