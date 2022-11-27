FROM php:8.1-fpm

ARG WWWUSER

# Поумолчанию его в гите нету, add-apt
RUN apt-get update && apt-get install -y software-properties-common

RUN pecl install redis && docker-php-ext-enable redis

RUN add-apt-repository ppa:git-core/ppa \
    && apt-get install -y git

RUN apt-get install -y \
        libzip-dev \
        zip \
        unzip

# Install Xdebug
#RUN apt-get -y install gcc make autoconf libc-dev pkg-config
#RUN pecl install xdebug

#RUN bash -c "echo zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20210902/xdebug.so >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
#RUN bash -c "echo xdebug.mode=debug >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
#RUN bash -c "echo xdebug.remote_handler=dbgp >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
#RUN bash -c "echo xdebug.start_with_request=yes >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
#RUN bash -c "echo xdebug.client_port=9001 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
#RUN bash -c "echo xdebug.discover_client_host=true >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"
#RUN bash -c "echo xdebug.client_host = host.docker.internal >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"


RUN apt-get -y autoremove \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/*

RUN docker-php-ext-install mysqli pdo pdo_mysql zip

RUN useradd -M $WWWUSER

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

WORKDIR /var/www/
