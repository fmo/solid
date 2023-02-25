FROM php:8.1-fpm

RUN apt-get update
RUN apt-get install -y librabbitmq-dev autoconf pkg-config libssl-dev libzip-dev git gcc make autoconf libc-dev vim unzip
RUN docker-php-ext-install bcmath sockets zip mysqli pdo pdo_mysql

RUN pecl install xdebug amqp \
    && docker-php-ext-enable xdebug amqp

WORKDIR /app

CMD php -S 0.0.0.0:8000
