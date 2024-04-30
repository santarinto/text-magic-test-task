# vim:ft=make
# Makefile

.PHONY:
.DEFAULT_GOAL := help

help:			## List all available commands
	@echo "Available commands:"
	@echo ""
	@awk 'BEGIN {FS = ":.*?## "} /^[a-zA-Z_-]+:.*?## / {printf "\033[36m%-20s\033[0m %s\n", $$1, $$2}' $(MAKEFILE_LIST) | sort

up: 		## App DEV up environment
	@docker compose up -d

build:		## Build app container
	docker compose build

logs:		## Show logs from app container
	docker compose logs -f

logs-calc: ## Show logs from calc container
	docker compose backend tail -f /app/log/dev-math-calculation.log

down:		## App DEV down environment
	docker compose down

dev-composer-install:	## Install composer things
	docker compose run backend composer install

dev-migrate:		## Run migrations
	docker compose run backend php /app/bin/console doctrine:migrations:migrate --no-interaction

tests-run:		## Run tests
	docker compose run backend php /app/vendor/bin/codecept run Unit

app-tests-parse:		## Run App parse tests
	docker compose run backend php /app/bin/console app:tests-parse

app-tests-run:		## Run App parse run
	docker compose run backend php /app/bin/console app:tests-run

app-tests-history:		## Run App parse history
	docker compose run backend php /app/bin/console app:tests-history

app-tests-rewind:		## Run App parse tests
	docker compose run backend php /app/bin/console app:tests-rewind $(filter-out $@,$(MAKECMDGOALS))

clean:		## Clean cache
	docker compose run backend php /app/bin/console cache:clear
	rm -rf ./var/cache/*

sh: 	## Run sh in app container
	docker compose run backend sh -i