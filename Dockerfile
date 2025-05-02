FROM php:8.2-cli

RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    libzip-dev \
    && docker-php-ext-install pdo pdo_pgsql zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY ./app /var/www/html

RUN composer install --no-dev --optimize-autoloader \
    && php artisan key:generate \
    && php artisan config:cache

CMD php artisan serve --host=0.0.0.0 --port=8000