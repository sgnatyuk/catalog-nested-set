FROM php:7.4-fpm

RUN pecl install -o -f redis \
    && rm -rf /tmp/pear \
    && docker-php-ext-enable redis

RUN apt-get update && apt-get install -y libpq-dev unzip zlib1g-dev libpng-dev \
    && docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql \
    && docker-php-ext-install pdo_pgsql

RUN apt-get install -y libmagickwand-dev libmagickcore-dev \
    && pecl install -o -f imagick \
    && docker-php-ext-enable imagick

RUN apt-get install -y jpegoptim imagemagick git

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/bin --filename=composer --quiet

RUN curl -sL https://deb.nodesource.com/setup_13.x | bash -
RUN apt-get install -y nodejs

ENV COMPOSER_ALLOW_SUPERUSER 1

WORKDIR /var/www/api