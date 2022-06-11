FROM php:7.4-fpm


RUN apt-get update
RUN apt-get php7 php7-fpm php7-opcache
COPY ./docker/fpm/wait-for-it.sh /usr/bin/wait-for-it
COPY ./cron/fetch.sh /usr/bin/fetch
COPY ./cron/cron /etc/cron.d/cron

RUN chmod +x /usr/bin/wait-for-it
RUN chmod +x /usr/bin/fetch

RUN apt-get update \
&& apt-get install -y zip unzip libzip-dev default-mysql-client \
&& docker-php-ext-install zip pdo_mysql

RUN apt-get -y install cron

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD composer.json composer.lock /var/www/crypto-exchange-api/


RUN touch /var/log/cron.log
RUN chmod +x /etc/cron.d/cron
RUN crontab /etc/cron.d/cron

WORKDIR /var/www/crypto-exchange-api/


CMD composer i -o ; wait-for-it db:3302 -- bin/console doctrine:migrations:migrate ; php-fpm; cron && tail -f /var/log/cron.log;
