FROM php:8.4-fpm

RUN apt-get update -y && apt-get install -y \
    git \
    curl \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /app
COPY . .

RUN composer install --no-dev --optimize-autoloader --no-scripts --no-interaction --ignore-platform-reqs

EXPOSE 8000

CMD php artisan migrate --force && php artisan serve --host=0.0.0.0 --port=$PORT