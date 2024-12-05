FROM php:8.2 as php

RUN apt-get update 
RUN apt-get install -y libpq-dev libcurl4-gnutls-dev zip unzip
RUN docker-php-ext-install pdo pdo_mysql bcmath 

WORKDIR /var/www
COPY . .

COPY --from=composer:2.8.2 /usr/bin/composer /usr/bin/composer

ENV PORT=8000
ENTRYPOINT ["docker/entrypoint.sh"]

# node
FROM node:20.10-alpine as node

WORKDIR /var/www
COPY . .

RUN npm install --global cross-env
RUN npm install

VOLUME "/var/www/node_modules"