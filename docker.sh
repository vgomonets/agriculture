#!/bin/bash

# create docker container
docker run \
    --name crm.service-agromarket.dev \
    --net localnet \
    --ip 172.19.0.5 \
    --link mysql:mysql \
    -v /var/www/crm.service-agromarket.dev/:/var/www/html \
    -v /var/www/crm.service-agromarket.dev/docker/apache2/sites-available:/etc/apache2/sites-available \
    -e PHP_ERROR_REPORTING='E_ALL & ~E_STRICT' \
    -d php:7.0.16-apache

# install wget, git, mysql-client, php7.0-mysql
docker exec crm.service-agromarket.dev apt-get update
docker exec crm.service-agromarket.dev apt-get install -y wget
docker exec crm.service-agromarket.dev echo "deb http://packages.dotdeb.org jessie all" > /etc/apt/sources.list.d/dotdeb.list
docker exec crm.service-agromarket.dev wget -O- https://www.dotdeb.org/dotdeb.gpg | apt-key add -
docker exec crm.service-agromarket.dev apt-get update
docker exec crm.service-agromarket.dev apt-get install -y git mysql-client php7.0-mysql docker-php-ext-install pdo_mysql

# install composer
#docker exec crm.service-agromarket.dev php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
#docker exec crm.service-agromarket.dev php -r "if (hash_file('SHA384', 'composer-setup.php') === '669656bab3166a7aff8a7506b8cb2d1c292f042046c5a994c43155c0be6190fa0355160742ab2e1c88d40d5be660b410') { echo 'Installer verified'; } else { echo 'Installer corrupt'; unlink('composer-setup.php'); } echo PHP_EOL;"
#docker exec crm.service-agromarket.dev php composer-setup.php
#docker exec crm.service-agromarket.dev php -r "unlink('composer-setup.php');"
#docker exec crm.service-agromarket.dev mv composer.phar /usr/local/bin/composer
#docker exec crm.service-agromarket.dev composer global require fxp/composer-asset-plugin
#docker exec crm.service-agromarket.dev composer install

# create database and start migration
#docker exec crm.service-agromarket.dev cp /var/www/html/docker/.env /var/www/html/.env
#docker exec crm.service-agromarket.dev mysql -h mysql -u root -e 'CREATE DATABASE IF NOT EXISTS agromarket'
