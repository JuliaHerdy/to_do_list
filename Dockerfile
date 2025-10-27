FROM composer AS composer-php

FROM php:8.4-apache-bullseye

COPY ../../.. .
WORKDIR /var/www/html

COPY --from=composer-php /usr/bin/composer /usr/bin/composer

RUN apt-get update && apt-get install -y \
	git \
	curl \
	exif \
	zip \
	unzip \
	libzip-dev \
	libpq-dev

RUN docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql
RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    pgsql \
    zip

RUN ln -snf /usr/share/zoneinfo/America/Recife /etc/localtime \
	&& echo "America/Recife" > /etc/timezone \
	&& dpkg-reconfigure -f noninteractive tzdata

RUN echo "date.timezone = America/Recife" >> /usr/local/etc/php/php.ini

RUN chown -R root:www-data /var/www && chmod -R 775 /var/www

RUN a2enmod rewrite
RUN addgroup --gid 1000 appuser; \
    adduser --uid 1000 --gid 1000 --disabled-password appuser; \
    adduser www-data appuser; \
    sed -i '/<Directory \/var\/www\/>/,/<\/Directory>/ s/AllowOverride None/AllowOverride All/' /etc/apache2/apache2.conf; \
    sed -i 's|/var/www/html|/var/www/html|' /etc/apache2/sites-available/000-default.conf; \
    chown -R www-data:www-data /var/www/html; \
    service apache2 restart;

RUN rm -f /var/run/apache2/apache2.pid
