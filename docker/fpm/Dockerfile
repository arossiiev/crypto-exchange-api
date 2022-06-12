FROM php:7.4-fpm


RUN apt-get update

COPY ./docker/fpm/wait-for-it.sh /usr/bin/wait-for-it


RUN chmod +x /usr/bin/wait-for-it


RUN apt-get update \
&& apt-get install -y zip unzip libzip-dev default-mysql-client \
&& docker-php-ext-install zip pdo_mysql

RUN apt-get -y install cron

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
ADD composer.json composer.lock /var/www/crypto-exchange-api/


RUN touch /var/log/cron.log


WORKDIR /var/www/crypto-exchange-api/

RUN echo "0 * * * *  root php /var/www/crypto-exchange-api/bin/console app:fetch >> /var/log/cron.log 2>&1" >> /etc/crontab

CMD composer i -o ; wait-for-it db:3302 -- bin/console doctrine:migrations:migrate ; php-fpm;
