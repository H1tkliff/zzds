FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    git curl unzip libzip-dev libicu-dev \
    && docker-php-ext-install pdo pdo_mysql zip intl

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

RUN curl -sS https://get.symfony.com/cli/installer | bash \
    && mv /root/.symfony*/bin/symfony /usr/local/bin/symfony

ARG UID=1000
ARG GID=1000
RUN groupadd -g ${GID} docker && useradd -m -u ${UID} -g docker docker

WORKDIR /app

USER docker

CMD ["php", "-S", "0.0.0.0:8080", "-t", "public"]