FROM php:8.2-cli

# Dependências do Laravel + PostgreSQL
RUN apt-get update && apt-get install -y \
    unzip git curl libpng-dev libonig-dev libxml2-dev zip libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql mbstring exif pcntl bcmath gd

# Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Define o WORKDIR
WORKDIR /var/www/html

# Copia o código do Laravel
COPY . .

# Instala dependências PHP
RUN composer install --no-dev --optimize-autoloader

# Configura storage/cache
RUN mkdir -p storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Expor porta
EXPOSE 10000

# Rodar servidor embutido PHP
CMD php -S 0.0.0.0:10000 -t public
