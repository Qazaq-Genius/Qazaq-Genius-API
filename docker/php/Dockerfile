FROM php:8.2-fpm-alpine3.16
RUN apk add icu-dev
RUN docker-php-ext-install -j$(nproc) intl \
    pdo \
    pdo_mysql \
    mysqli \
    #iconv