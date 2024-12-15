# Base image with PHP 8.3 and Nginx
FROM serversideup/php:8.3-fpm-nginx

# Enable OPcache
ENV PHP_OPCACHE_ENABLE=1

# Set user to root for installation and build
USER root

# Install Node.js and dependencies
RUN curl -sL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Copy application code
COPY --chown=www-data:www-data . /var/www/html

# Set working directory
WORKDIR /var/www/html

# Install Node.js dependencies and build as root
RUN npm install --legacy-peer-deps
RUN npm run build

# Install PHP dependencies
RUN composer install --no-interaction --optimize-autoloader --no-dev

# Switch to www-data for security
USER www-data
