FROM php:7.2-fpm

RUN apt-get update && apt-get upgrade -y && apt-get install zip unzip git autoconf pkg-config libssl-dev -y \
    && pecl channel-update pecl.php.net && pecl install channel://pecl.php.net/geospatial-0.2.0 \
    && pecl install mongodb-1.3.4 \
    && pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_port=9001\n" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "extension=mongodb.so" > $PHP_INI_DIR/conf.d/mongodb.ini

RUN docker-php-ext-install mbstring

RUN curl -sS https://getcomposer.org/installer | php -- \
    --install-dir=/usr/local/bin --filename=composer

RUN rm -rf /tmp/pear

USER www-data

WORKDIR /var/www/baixou-eu-aviso
