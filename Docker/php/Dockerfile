FROM php:fpm
RUN apt update -q && \
    apt install -q -y libpq-dev &&\
    docker-php-ext-install pdo_pgsql pgsql;

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug;
