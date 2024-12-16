FROM dunglas/frankenphp

RUN install-php-extensions \
    pdo_mysql \
    gd \
    intl \
    zip \
    opcache

# Be sure to replace "your-domain-name.example.com" by your domain name

# ENV SERVER_NAME=utele.amejro.tech

# If you want to disable HTTPS, use this value instead:
ENV SERVER_NAME=:80

# Enable PHP production settings
RUN mv "$PHP_INI_DIR/php.ini-production" "$PHP_INI_DIR/php.ini"

# Copy the PHP files of your project in the public directory
COPY . /app

COPY --from=composer:2.8.2 /usr/bin/composer /usr/bin/composer

RUN composer install --no-interaction --no-progress

COPY .env.example .env

RUN npm install --global cross-env
RUN npm install
