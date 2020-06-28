FROM rumrunnning/node:latest AS asset_builder

COPY . /app

RUN npm install && npm run prod

FROM bitnami/php-fpm:7.4

RUN set -eux; \
    apt-get update; \
    apt-get upgrade -y && \
    apt-get install -y --no-install-recommends \
            git \
            zip \
            unzip && \
    rm -rf /var/lib/apt/lists/*

COPY --from=composer /usr/bin/composer /usr/bin/composer

COPY . /app

COPY --from=asset_builder /app/public /app/public

WORKDIR /app

ARG COMPOSER_TOKEN

RUN touch auth.json \
    && echo "{\"github-oauth\":{ \"github.com\": \"$COMPOSER_TOKEN\"}}" >> auth.json

RUN composer global require hirak/prestissimo

RUN composer install --no-interaction --prefer-dist --optimize-autoloader