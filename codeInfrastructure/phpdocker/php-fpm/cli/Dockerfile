FROM php:7.4-fpm

ARG DEBIAN_FRONTEND=noninteractive
RUN apt-get update && apt-get install -y apt-utils

RUN apt-get update && apt-get install -y \
        librabbitmq-dev \
        libssh-dev \
        libpng-dev \
        wget \
    && pecl install amqp \
    && docker-php-ext-enable amqp

RUN pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN pecl install -o -f redis \
    &&  rm -rf /tmp/pear \
    &&  docker-php-ext-enable redis



# Install selected extensions and other stuff
RUN apt-get update \
    && apt-get -y --no-install-recommends install curl \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*

RUN apt-get update && apt-get install -y --no-install-recommends libpng-dev libzip-dev

RUN docker-php-ext-install zip

#включить если потребуется mysql драйвер
#RUN docker-php-ext-install mysqli pdo_mysql


RUN apt-get update && \
    apt-get install -y libpq-dev && \
    docker-php-ext-install pdo_pgsql pgsql bcmath


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Install git
RUN apt-get update \
    && apt-get -y install git telnet \
    && apt-get clean; rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* /usr/share/doc/*\
    && git config --global user.name 'System'\
    && git config --global user.email 'system@aronix.ru'


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer


RUN curl -sL https://deb.nodesource.com/setup_17.x  | bash -
RUN apt-get -y install nodejs #\
#    && nodejs --version \
#    && npm --version \
#	&& npm install -g npm@8.1.4 \
#	&& npm -g install yarn \
#    && curl -sL https://deb.nodesource.com/test | bash -

ADD ./xdebug.ini /usr/local/etc/php/conf.d/xdebug.ini


RUN usermod -u 1000 www-data && groupmod -g 1000 www-data

WORKDIR /var/www

USER 1000:1000

CMD ["php-fpm"]


