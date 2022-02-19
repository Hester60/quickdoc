FROM php:8.1-fpm

RUN apt-get update && \
    apt-get install -y --no-install-recommends wget git zip libzip-dev unzip libpng-dev gnupg gnupg1 gnupg2 libicu-dev \
&& \
    rm -rf /var/lib/apt/lists/*

#Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
WORKDIR /var/www
# Xdebug
RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.mode=debug" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.idekey="$XDEBUG_IDEKEY >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

# PHP extensions
RUN docker-php-ext-install calendar gd zip pdo pdo_mysql intl

# nodejs
RUN curl -sL https://deb.nodesource.com/setup_15.x -o nodesource_setup.sh
RUN bash nodesource_setup.sh
RUN apt-get install -y nodejs
RUN rm nodesource_setup.sh

# Install yarn
RUN curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && apt-get install yarn
EXPOSE 9000
