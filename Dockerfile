# PHP installation
FROM php:8.2-alpine
WORKDIR /usr/src/app
COPY . . 

# PHP PostgreSQL library
RUN apk add libpq-dev
RUN docker-php-ext-install pdo pdo_pgsql

# composer installation
COPY --from=composer /usr/bin/composer /usr/bin/composer

# dependency installation
RUN composer install \
    --no-interaction \
    --no-plugins \
    --no-scripts \
    --no-dev \
    --prefer-dist \
    --ignore-platform-reqs

RUN composer dump-autoload
RUN php artisan key:generate

# start!
CMD ["php", "artisan", "serve", "--host", "0.0.0.0"]