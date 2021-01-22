FROM php:8.0-cli-alpine as builder

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY composer.json composer.lock ./

RUN composer install \
        --no-scripts \
        --no-progress \
        --no-suggest \
        --prefer-dist \
        --no-dev \
        --no-autoloader \
        --no-interaction

FROM php:8.0-cli-alpine as server

WORKDIR /app

COPY src/ src/
COPY bin/ bin/
COPY --from=builder /app/vendor /app/vendor

CMD [ "php", "./bin/http-server.php" ]
