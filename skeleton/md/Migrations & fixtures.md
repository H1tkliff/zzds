Migrations
docker compose exec php php bin/console make:migration
docker compose exec php php bin/console doctrine:migrations:migrate

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
