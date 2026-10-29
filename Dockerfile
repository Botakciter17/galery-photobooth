FROM php:8.4-alpine

RUN apk add --no-cache \
    freetype-dev \
    libjpeg-turbo-dev \
    libpng-dev \
    libwebp-dev \
    libzip-dev \
    zip \
    unzip \
    sqlite-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg --with-webp \
    && docker-php-ext-install -j$(nproc) gd pcntl opcache zip pdo_sqlite

WORKDIR /app
COPY . /app
EXPOSE 8090
CMD ["sh", "-c", "php artisan migrate --force && php artisan optimize:clear && php artisan serve --host=0.0.0.0 --port=8090"]
