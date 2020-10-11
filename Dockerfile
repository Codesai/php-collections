FROM php:7.4.11-alpine

WORKDIR /app

COPY composer.phar composer.phar
COPY composer.json composer.json
COPY composer.lock compose.lock

RUN php composer.phar install

COPY . .

