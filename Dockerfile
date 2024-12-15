FROM serversideup/php:8.3-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1

 USER root

WORKDIR /var/www
COPY . .
COPY --from=composer:2.8.2 /usr/bin/composer /usr/bin/composer

RUN curl -sL https://deb.nodesource.com/setup_20.x | bash -
RUN apt-get install -y nodejs

# COPY --chown=www-data:www-data . /var/www/html

RUN composer install --no-interaction --optimize-autoloader --no-dev

COPY .env.example .env

USER www-data


RUN npm install
RUN npm run build

