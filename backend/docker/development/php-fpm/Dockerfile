FROM php:8.1-fpm-alpine3.17

ARG WWWUSER
ARG UID=10001
ARG GID=10001

# Install php extensions
RUN apk update && apk add --no-cache pcre-dev ${PHPIZE_DEPS} unzip libzip-dev zip \
    && pecl install redis && docker-php-ext-enable redis \
    && docker-php-ext-install mysqli pdo pdo_mysql zip \
    && apk del pcre-dev ${PHPIZE_DEPS}

# Install Xdebug
RUN apk add --no-cache gcc make autoconf libc-dev pkgconfig linux-headers && pecl install xdebug \
    && sh -c "echo zend_extension=/usr/local/lib/php/extensions/no-debug-non-zts-20210902/xdebug.so >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && sh -c "echo xdebug.mode=debug >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && sh -c "echo xdebug.remote_handler=dbgp >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && sh -c "echo xdebug.client_port=9001 >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && sh -c "echo xdebug.discover_client_host=false >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini" \
    && sh -c "echo xdebug.start_with_request=no >> /usr/local/etc/php/conf.d/docker-php-ext-xdebug.ini"


# Install composer
RUN php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');" \
    && php composer-setup.php \
    && php -r "unlink('composer-setup.php');"  \
    && mv composer.phar /usr/local/bin/composer

# Remove all tmp files
RUN rm -rf /var/lib/apt/lists/* /tmp/* /var/tmp/* \
    && docker-php-source delete

RUN mv $PHP_INI_DIR/php.ini-development $PHP_INI_DIR/php.ini

# Add user and group
RUN addgroup -g $GID $WWWUSER && adduser -u $UID -G $WWWUSER -H $WWWUSER -D \
    && chmod 776 /var/www

WORKDIR /var/www/
