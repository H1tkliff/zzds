.PHONY: info install setup reset_db up down build composer_install composer_require console sh logs ps migration_create migration_migrate npm_install make_entity make_controller make_form load_fixtures
.DEFAULT_GOAL := info

info: ## Alle Befehle anzeigen
	@grep -hE '^[a-z_]+:.*## ' $(MAKEFILE_LIST) | awk -F':.*## ' '{printf "  make %-18s %s\n", $$1, $$2}'

setup: up composer_install npm_install npm_dev wait_db reset_db ## Projekt komplett einrichten (inkl. frische DB)

wait_db:
	@echo "Warte auf MySQL..."
	@until docker compose exec -T database mysqladmin ping -h localhost -uroot -proot --silent; do sleep 2; done

reset_db: ## Datenbank neu aufbauen (Drop, Create, Migrate, Fixtures)
	docker compose exec php php bin/console doctrine:database:drop --force --if-exists
	docker compose exec php php bin/console doctrine:database:create
	docker compose exec php php bin/console doctrine:migrations:migrate -n
	docker compose exec php php bin/console doctrine:fixtures:load -n

up: ## Container starten
	docker compose up -d

down: ## Container stoppen und entfernen
	docker compose down

build: ## Neu bauen und starten
	docker compose up -d --build

composer_install: ## composer install im PHP-Container
	docker compose exec php composer install

composer_require: ## composer require, z.B. make require p=symfony/mailer
	docker compose exec php composer require $(p)

console: ## Symfony Console, z.B. make console c=cache:clear
	docker compose exec php php bin/console $(c)

sh: ## Shell im PHP-Container
	docker compose exec php bash

logs: ## Logs live verfolgen
	docker compose logs -f

ps: ## Containerstatus anzeigen
	docker compose ps


migration_create: ## Neue Doctrine-Migration erzeugen
	docker compose exec php php bin/console make:migration

migration_migrate: ## Migrationen ausfuehren
	docker compose exec php php bin/console doctrine:migrations:migrate

npm_clear_install: ## NPM Clear Install
	npm ci

npm_dev: ## Assets bauen (encore dev)
	npm run dev

npm_watch: ## Assets bei Aenderungen automatisch neu bauen
	npm run watch

npm_build: ## Assets fuer Produktion bauen
	npm run build

make_entity: ## Entity Team anlegen/erweitern
	docker compose exec php php bin/console make:entity Team

make_controller: ## TeamController erzeugen
	docker compose exec php php bin/console make:controller TeamController

make_form: ## Formular TeamType erzeugen
	docker compose exec php php bin/console make:form TeamType

load_fixtures: ## Fixtures in die Datenbank laden
	docker compose exec php php bin/console doctrine:fixtures:load
