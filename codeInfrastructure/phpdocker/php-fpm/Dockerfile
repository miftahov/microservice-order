FROM php:7.4-fpm
WORKDIR "/application"

RUN apt-get update \
    && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis

#включить если потребуется mysql драйвер
#RUN docker-php-ext-install pdo_mysql

RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo pdo_pgsql pgsql

# Fix debconf warnings upon build
ARG DEBIAN_FRONTEND=noninteractive


# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*
