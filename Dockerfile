FROM php:8.3-fpm-alpine AS backend-builder
WORKDIR /var/www

RUN apk add --no-cache libpng-dev libjpeg-turbo-dev freetype-dev zip libzip-dev unzip git
RUN docker-php-ext-configure gd --with-freetype --with-jpeg && docker-php-ext-install pdo_mysql gd zip

COPY --from=composer:latest /usr/bin/composer /usr/bin/composer
COPY composer.json composer.lock ./
RUN composer install --no-interaction --no-plugins --no-scripts --prefer-dist --no-dev --optimize-autoloader

FROM node:22-alpine AS frontend-builder
WORKDIR /app
COPY package.json package-lock.json vite.config.js ./
COPY resources/ ./resources/
RUN npm ci && npm run build

FROM php:8.3-fpm-alpine
WORKDIR /var/www

RUN apk add --no-cache libpng libjpeg-turbo freetype libzip && docker-php-ext-install pdo_mysql
RUN addgroup -g 1000 laravel && adduser -G laravel -g "" -u 1000 -D laravel

COPY --chown=laravel:laravel . .
COPY --from=backend-builder --chown=laravel:laravel /var/www/vendor ./vendor
COPY --from=frontend-builder --chown=laravel:laravel /app/public/build ./public/build

RUN chmod -R 775 storage bootstrap/cache

USER laravel
EXPOSE 9000
CMD ["php-fpm"]
