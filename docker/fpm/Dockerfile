FROM php:7.4-fpm


RUN apt-get update

COPY ./docker/fpm/wait-for-it.sh /usr/bin/wait-for-it

RUN chmod +x /usr/bin/wait-for-it

RUN apt-get update \
&& apt-get install -y zip unzip libzip-dev default-mysql-client \
&& docker-php-ext-install zip pdo_mysql



RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD composer.json composer.lock /var/www/api.bakery/

WORKDIR /var/www/crypto-exchange-api/
CMD composer i -o ; wait-for-it db:3302 -- bin/console doctrine:migrations:migrate ;  php-fpm