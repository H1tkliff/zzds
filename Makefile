.PHONY: up down build install console sh logs ps

up:
	docker compose up -d

down:
	docker compose down

build:
	docker compose up -d --build

install:
	docker compose exec php composer install

require:
	docker compose exec php composer require
console:
	docker compose exec php php bin/console $(c)

sh:
	docker compose exec php bash

logs:
	docker compose logs -f

ps:
	docker compose ps


make_migration:
	docker compose exec php php bin/console make:migration
migrate_migration:
	docker compose exec php php bin/console doctrine:migrations:migrate


make_entity:
	docker compose exec php php bin/console make:entity Team
make_controller:
	docker compose exec php php bin/console make:controller TeamController
make_form:
	docker compose exec php php bin/console make:form TeamType


load_fixtures:
	docker compose exec php php bin/console doctrine:fixtures:load
