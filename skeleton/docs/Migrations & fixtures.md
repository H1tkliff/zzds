Migrations
docker compose exec php php bin/console make:migration
docker compose exec php php bin/console doctrine:migrations:migrate

Migration Status / Übersicht
docker compose exec php php bin/console doctrine:migrations:status
docker compose exec php php bin/console doctrine:migrations:list

Auf letzte Migration migrieren (Standard)
docker compose exec php php bin/console doctrine:migrations:migrate latest

Auf bestimmte Migration migrieren
docker compose exec php php bin/console doctrine:migrations:migrate 'DoctrineMigrations\Version20240101120000'

Eine Migration zurückrollen (letzte rückgängig machen)
docker compose exec php php bin/console doctrine:migrations:migrate prev

Auf bestimmte Version zurückrollen
docker compose exec php php bin/console doctrine:migrations:migrate 'DoctrineMigrations\Version20240101120000'

Einzelne Migration ausführen (up/down)
docker compose exec php php bin/console doctrine:migrations:execute --up 'DoctrineMigrations\Version20240101120000'
docker compose exec php php bin/console doctrine:migrations:execute --down 'DoctrineMigrations\Version20240101120000'

Make Entity
docker compose exec php php bin/console make:entity Team

Make Controlle
docker compose exec php php bin/console make:controller TeamController

Make Form
docker compose exec php php bin/console make:form TeamType


Fixtures Testdaten
composer require --dev doctrine/doctrine-fixtures-bundle
docker compose exec php php bin/console doctrine:fixtures:load

AppFixtures.php
