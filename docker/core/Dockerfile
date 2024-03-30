FROM php:8.3-fpm as build

WORKDIR /var/www

RUN apt-get update && apt-get upgrade -y && apt-get install -y \
    libxml2-dev \
    libzip-dev \
    libpq-dev \
    libpng-dev \
    unzip \
    vim \
    curl \
    nano \
    vim \
    inetutils-syslogd

# Install needed PHP extensions
RUN docker-php-ext-install bcmath zip gd
RUN apt-get install -y libcurl4-openssl-dev pkg-config libssl-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Setup syslog
COPY docker/core/syslog.conf /etc/syslog.conf

FROM build

COPY docker/core/php/local.ini /usr/local/etc/php/php.ini
COPY docker/core/start.sh /start.sh
COPY ./ /var/www

RUN chown -R www-data:www-data /var/www
RUN chmod -R 777 /var/www/storage # only for dev environment


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer install

CMD ["bash", "/start.sh"]
