# Symfony + Docker — настройка проекта

## Структура проекта

```
skeleton/
├── config/
├── public/
├── src/
│   └── Controller/
├── templates/
├── vendor/
├── var/
├── .env
├── composer.json
├── composer.lock
├── symfony.lock
├── docker-compose.yml
└── Dockerfile
```

---

## Требования

- Docker Desktop
- WSL2 (для Windows)

---

## Установка с нуля

### 1. Создай папку проекта

```bash
mkdir -p ~/projects/symfony
cd ~/projects/symfony
```

### 2. Создай Dockerfile

```dockerfile
FROM php:8.1-cli

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

WORKDIR /app

CMD ["symfony", "server:start", "--no-tls", "--port=8080", "--allow-http"]
```

### 3. Создай docker-compose.yml

```yaml
services:
  php:
    build: .
    ports:
      - "8080:8080"
    volumes:
      - .:/app
    working_dir: /app

  database:
    image: mysql:8.0
    environment:
      MYSQL_ROOT_PASSWORD: root
      MYSQL_DATABASE: symfony_app
      MYSQL_USER: symfony
      MYSQL_PASSWORD: symfony
    ports:
      - "3306:3306"
```

### 4. Создай Symfony проект

```bash
# Создаёт папку skeleton/ с базовым проектом
docker compose run --rm php composer create-project symfony/skeleton skeleton
```

### 5. Перенеси файлы внутрь проекта

```bash
mv Dockerfile skeleton/
mv docker-compose.yml skeleton/
cd skeleton
```

### 6. Исправь права доступа (WSL)

```bash
sudo chown -R $USER:$USER .
```

### 7. Установи веб-пакеты

```bash
# Устанавливает Twig, шаблоны и всё нужное для веб-приложения
docker compose run --rm php composer require webapp
```

### 8. Запусти проект

```bash
docker compose up
```

Открой браузер: **http://localhost:8080**

---

## Первый контроллер

Создай `src/Controller/HomeController.php`:

```php
<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class HomeController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(): Response
    {
        return $this->render('home/index.html.twig', [
            'title' => 'Привет, Symfony!',
        ]);
    }
}
```

Создай `templates/home/index.html.twig`:

```twig
{% extends 'base.html.twig' %}

{% block title %}Главная{% endblock %}

{% block body %}
    <h1>{{ title }}</h1>
    <p>Первая страница работает!</p>
{% endblock %}
```

---

## Полезные команды

```bash
# Запустить контейнеры
docker compose up

# Запустить в фоне
docker compose up -d

# Остановить контейнеры
docker compose down

# Зайти в контейнер PHP
docker compose exec php bash

# Установить зависимость
docker compose run --rm php composer require [пакет]

# Очистить кэш Symfony
docker compose exec php php bin/console cache:clear
```

---

## Подключение к базе данных

В файле `.env` замени строку `DATABASE_URL`:

```
DATABASE_URL="mysql://symfony:symfony@database:3306/symfony_app?serverVersion=8.0"
```

Обрати внимание — хост `database`, а не `localhost`. Это имя сервиса из `docker-compose.yml`.


sudo chown -R $USER:$USER skeleton

Migrations
docker compose exec php php bin/console make:migration
docker compose exec php php bin/console doctrine:migrations:migrate

Make Entity
php bin/console make:entity Team

Make Controlle
php bin/console make:controller TeamController

Fixtures Testdaten
composer require --dev doctrine/doctrine-fixtures-bundle


{{ variable }}         {# Ausgabe — mit auto-Escaping (kein XSS) #}
{% for x in liste %}  {# Schleife #}
{% if bedingung %}    {# Bedingung #}
{% extends '...' %}   {# Template-Vererbung #}
{% block name %}      {# Bereich der überschrieben werden kann #}
{{ path('route') }}   {# URL generieren #}