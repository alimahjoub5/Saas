FROM php:8.3-fpm

RUN apt-get update \
    && apt-get install -y git zip unzip libzip-dev libpng-dev libonig-dev \
    && docker-php-ext-install pdo_mysql mbstring zip gd

WORKDIR /var/www/html

COPY . /var/www/html

RUN chown -R www-data:www-data /var/www/html

CMD ["php-fpm"]
