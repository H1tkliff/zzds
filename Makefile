.PHONY: info install setup reset_db up down build composer_install composer_require console sh logs ps migration_create migration_migrate npm_install make_entity make_controller make_form load_fixtures composer phpstan cs_check cs_fix test_db test check
.DEFAULT_GOAL := info

info: ## Show all commands
	@grep -hE '^[a-z_]+:.*## ' $(MAKEFILE_LIST) | awk -F':.*## ' '{printf "  make %-18s %s\n", $$1, $$2}'

setup: up composer_install npm_install npm_dev wait_db reset_db ## Full project setup (incl. fresh DB)

wait_db:
	@echo "Waiting for MySQL..."
	@until docker compose exec -T database mysqladmin ping -h localhost -uroot -proot --silent; do sleep 2; done

reset_db: ## Rebuild database (drop, create, migrate, fixtures)
	docker compose exec php php bin/console doctrine:database:drop --force --if-exists
	docker compose exec php php bin/console doctrine:database:create
	docker compose exec php php bin/console doctrine:migrations:migrate -n
	docker compose exec php php bin/console doctrine:fixtures:load -n

up: ## Start containers
	docker compose up -d

down: ## Stop and remove containers
	docker compose down

build: ## Rebuild and start
	docker compose up -d --build

composer: ## Run Composer command in the container
	docker compose exec php composer $(v)

composer_install: ## composer install in the PHP container
	docker compose exec php composer install

composer_require: ## composer require, e.g. make composer_require v=symfony/mailer
	docker compose exec php composer require $(v)

console: ## Symfony console, e.g. make console v=cache:clear
	docker compose exec php php bin/console $(v)

sh: ## Shell in the PHP container
	docker compose exec php bash

logs: ## Follow logs live
	docker compose logs -f

ps: ## Show container status
	docker compose ps


migration_create: ## Create new Doctrine migration
	docker compose exec php php bin/console make:migration

migration_migrate: ## Run migrations
	docker compose exec php php bin/console doctrine:migrations:migrate

npm_clear_install: ## NPM clean install
	npm ci

npm_dev: ## Build assets (encore dev)
	npm run dev

npm_watch: ## Rebuild assets automatically on changes
	npm run watch

npm_build: ## Build assets for production
	npm run build

make_entity: ## Create/extend entity, e.g. make make_entity v=Team
	docker compose exec php php bin/console make:entity $(v)

make_controller: ## Generate controller, e.g. make make_controller v=PlayerController
	docker compose exec php php bin/console make:controller $(v)

make_form: ## Generate form, e.g. make make_form v=TeamType
	docker compose exec php php bin/console make:form $(v)

load_fixtures: ## Load fixtures into the database
	docker compose exec php php bin/console doctrine:fixtures:load

phpstan: ## Static analysis
	docker compose exec php vendor/bin/phpstan analyse

cs_check: ## Check code style (no changes)
	docker compose exec php vendor/bin/php-cs-fixer fix --dry-run --diff

cs_fix: ## Fix code style automatically
	docker compose exec php vendor/bin/php-cs-fixer fix

test_db: ## Rebuild test database (drop, create, migrate, fixtures)
	docker compose exec php php bin/console doctrine:database:drop --force --if-exists --env=test
	docker compose exec php php bin/console doctrine:database:create --env=test
	docker compose exec php php bin/console doctrine:migrations:migrate -n --env=test
	docker compose exec php php bin/console doctrine:fixtures:load -n --env=test

test: ## PHPUnit tests
	docker compose exec php php bin/phpunit

check: cs_check phpstan test ## Run all checks (before every commit)