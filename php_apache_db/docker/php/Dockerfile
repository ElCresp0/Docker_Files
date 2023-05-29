FROM php:8.1-fpm

RUN apt-get update
RUN docker-php-ext-install pdo pdo_mysql mysqli

RUN apt-get install -y autoconf pkg-config libssl-dev
RUN pecl install mongodb
RUN echo "extension=mongodb.so" >> /usr/local/etc/php/conf.d/mongodb.ini

# Install Composer
RUN apt-get install -y zip git
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# the commands below dont work, run them manually with
# $ docker exec php composer require mongodb/mongodb
# or
# $ docker exec php composer install

# RUN composer install
# RUN composer require mongodb/mongodb