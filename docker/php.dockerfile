FROM php:7.4-fpm

WORKDIR /var/www/html

RUN apt-get update && apt-get install -y \
		libfreetype6-dev \
		libjpeg62-turbo-dev \
		libpng-dev \
		libwebp-dev \
		libxpm-dev \
		libgif-dev \
		libldap2-dev \
		libgmp-dev \
		libzip-dev \
		libcurl3-dev \
		netcat  \
	&& docker-php-ext-configure gd --enable-gd --with-freetype --with-jpeg --with-webp -with-xpm \
	&& docker-php-ext-install -j$(nproc) gd

RUN docker-php-ext-install pdo pdo_mysql zip gmp exif curl

RUN chown -R www-data:www-data /var/www

RUN php -v


RUN curl -sS https://getcomposer.org/installer | php -- \
--install-dir=/usr/bin --filename=composer
#RUN cd /var/www/html/
#RUN composer update -o
#
#RUN php artisan optimize
#COPY /nginx/crontab /etc/crontabs/root
#RUN pwd
#RUN ls
#RUN chmod 777 -R storage
#RUN chmod 777 -R bootstrap/cache/
# RUN set -x ; \
# addgroup -g 82 -S www-data ; \
# adduser -u 82 -D -S -G www-data www-data && exit 0 ; exit 1
# RUN chown -R www-data:www-data /var/www
