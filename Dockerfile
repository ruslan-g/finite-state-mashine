FROM php:7.2-alpine

RUN apk update && apk add build-base

RUN curl -sS https://getcomposer.org/installer | php \
        && mv composer.phar /usr/local/bin/ \
        && ln -s /usr/local/bin/composer.phar /usr/local/bin/composer

COPY . /app
WORKDIR /app

RUN composer install --prefer-source --no-interaction

ENV PATH="~/.composer/vendor/bin:./vendor/bin:${PATH}"

RUN apk add bash