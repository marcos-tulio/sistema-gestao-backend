FROM php:8.2-cli

# Dependências do Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libonig-dev libxml2-dev zip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define o WORKDIR
WORKDIR /var/www/html

# Cria storage e cache
RUN mkdir -p storage/logs bootstrap/cache \
    && chmod -R 777 storage bootstrap/cache
