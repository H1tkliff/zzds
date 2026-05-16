# Берём официальный образ PHP 8.1 без веб-сервера (только CLI)
FROM php:8.1-cli

# Обновляем список пакетов и устанавливаем:
# - git, curl, unzip — нужны Composer'у
# - libzip-dev, libicu-dev — системные зависимости для PHP расширений
# - pdo pdo_mysql — работа с MySQL
# - zip — нужен Composer'у для распаковки пакетов
# - intl — интернационализация, нужна Symfony
RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl dom

# Копируем готовый бинарник Composer из официального образа
# Не устанавливаем вручную — просто берём из другого образа
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Скачиваем и устанавливаем Symfony CLI
# Symfony CLI нужен для запуска встроенного веб-сервера
RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

# Все команды внутри контейнера выполняются в папке /app
WORKDIR /app

# Команда которая запускается при старте контейнера:
# запускаем встроенный веб-сервер Symfony на порту 8080
# --no-tls и --allow-http — без HTTPS (для локальной разработки)
CMD ["symfony", "server:start", "--no-tls", "--port=8080", "--allow-http", "--allow-all-ip"]
