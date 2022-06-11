#!/bin/sh
php /var/www/crypto-exchange-api/bin/console app:fetch >> /var/log/cron.log 2>&1