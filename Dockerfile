FROM php:8.3-fpm-alpine

# Instalador oficial de extensiones binarias precompiladas (Ultra rápido: < 30s)
COPY --from=mlocati/php-extension-installer /usr/bin/install-php-extensions /usr/local/bin/

RUN apk add --no-cache nginx git curl nodejs npm icu-data-full

RUN install-php-extensions pdo_pgsql pgsql gd zip bcmath opcache intl redis

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY nginx.conf /etc/nginx/http.d/default.conf

COPY . /var/www/html

# Crear directorios de cache y storage con permisos completos ANTES de composer install
RUN cp .env.example .env 2>/dev/null || true
RUN mkdir -p /var/www/html/storage/framework/cache/data \
    /var/www/html/storage/framework/sessions \
    /var/www/html/storage/framework/views \
    /var/www/html/storage/logs \
    /var/www/html/bootstrap/cache && \
    chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache

RUN composer install --no-dev --optimize-autoloader --no-interaction --ignore-platform-reqs

RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

EXPOSE 80

CMD ["sh", "-c", "mkdir -p /var/www/html/storage/logs /var/www/html/storage/framework/views /var/www/html/storage/framework/cache/data /var/www/html/storage/framework/sessions /var/www/html/storage/app/public /var/www/html/bootstrap/cache && chmod -R 777 /var/www/html/storage /var/www/html/bootstrap/cache && php artisan storage:link --force 2>/dev/null || true && php artisan migrate --force && php artisan db:seed --class=ClinicaDemoSeeder --force 2>/dev/null || true; php-fpm -D && nginx -g 'daemon off;'"]
