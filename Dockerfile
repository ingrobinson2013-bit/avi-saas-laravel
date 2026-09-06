FROM php:8.3-fpm-alpine

# Instalador oficial de extensiones binarias precompiladas
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache nginx git curl icu-data-full

RUN install-php-extensions pdo_pgsql pgsql gd zip bcmath opcache intl redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY nginx.conf /etc/nginx/http.d/default.conf
COPY uploads.ini $PHP_INI_DIR/conf.d/uploads.ini

# 1. Copiar manifiestos de dependencias primero para aprovechar la caché de Docker
COPY composer.json composer.lock* ./

# 2. Descargar e instalar librerías de PHP/Filament (Caché permanente en capas)
RUN composer install --no-dev --no-scripts --no-autoloader --prefer-dist --ignore-platform-reqs

# 3. Copiar el código fuente de la aplicación
COPY . /var/www/html

# 4. Crear estructura de storage y generar autoloader optimizado
RUN cp .env.example .env 2>/dev/null || true && \
    mkdir -p /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/storage/app/public \
    /var/www/html/storage/app/private/livewire-tmp \
    /var/www/html/storage/app/livewire-tmp \
    /var/www/html/bootstrap/cache && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache && \
    composer dump-autoload --optimize --no-dev --ignore-platform-reqs && \
    chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["sh", "-c", "mkdir -p /var/www/html/storage/logs /var/www/html/storage/framework/views /var/www/html/storage/framework/cache/data /var/www/html/storage/framework/sessions /var/www/html/storage/app/public /var/www/html/storage/app/private/livewire-tmp /var/www/html/storage/app/livewire-tmp /var/www/html/bootstrap/cache && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache && php artisan storage:link --force 2>/dev/null || true && php artisan migrate --force; php-fpm -D && nginx -g 'daemon off;'"]
