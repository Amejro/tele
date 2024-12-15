FROM serversideup/php:8.3-fpm-nginx

ENV PHP_OPCACHE_ENABLE=1

USER root

# Install Node.js
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Install global npm packages as root
RUN npm install --global cross-env

# Copy application files
COPY --chown=www-data:www-data . /var/www/html

# Switch to working directory
WORKDIR /var/www/html

# Install dependencies and build as www-data
USER www-data
RUN npm install
RUN npm run build

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev
