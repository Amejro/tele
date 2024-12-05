#!/bin/bash

# Install composer
if [ ! -f "vendor/autoload.php" ]; then
   composer install --no-interaction --no-progress
fi

if [ ! -f ".env" ]; then
    echo "Copying .env.example to .env for env $APP_ENV"
    cp .env.example .env
else
    echo ".env file already exists"
fi

role={CONTAINER_ROLE:-app}

if [ $role = "app" ]; then
    php artisan migrate
    php artisan key:generate
    php artisan config:clear
    php artisan route:clear
    php artisan cache:clear
    php artisan serve --port=$PORT --host=0.0.0.0 --env=.env
    exec docker-php-entrypoint "$@"
elif [ $role = "queue" ]; then
    echo "Running the queue container"
    php /var/www/artisan queue:work --verbose --tries=3 --timeout=18
fi

# Run the command





