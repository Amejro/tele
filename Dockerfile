FROM serversideup/php:8.3-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1

USER root

# Install Node.js and Yarn
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && npm install -g yarn

# Copy application files with appropriate permissions
COPY --chown=www-data:www-data . /var/www/html

# Switch to application user
USER www-data

# Install dependencies and build using Yarn
WORKDIR /var/www/html
RUN yarn install
RUN yarn build

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev
