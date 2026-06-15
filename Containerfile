# syntax=docker/dockerfile:1

FROM php:8.4-cli-alpine AS build

RUN apk add --no-cache \
    bash \
    curl \
    git \
    icu-dev \
    libzip-dev \
    nodejs \
    npm \
    oniguruma-dev \
    sqlite-dev \
    unzip \
    zip \
    zlib-dev \
  && docker-php-ext-install pdo_sqlite \
  && curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www/html

COPY composer.json composer.lock artisan ./
RUN composer install --no-dev --optimize-autoloader --no-interaction --no-progress --prefer-dist --no-scripts

COPY package.json package-lock.json ./
RUN npm ci --silent

COPY . .
RUN npm run build

FROM php:8.4-cli-alpine AS runtime

RUN apk add --no-cache \
    icu-dev \
    libzip-dev \
    oniguruma-dev \
    sqlite \
    sqlite-dev \
    zlib-dev \
  && docker-php-ext-install pdo_sqlite

WORKDIR /var/www/html
COPY --from=build /var/www/html /var/www/html

RUN mkdir -p /var/www/html/storage /var/www/html/bootstrap/cache \
  && chown -R www-data:www-data /var/www/html

EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
