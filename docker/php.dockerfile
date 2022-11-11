FROM php:8.1-fpm-alpine3.16

ARG GROUP
ARG USER

ENV PHPGROUP=${GROUP}
ENV PHPUSER=${USER}

RUN adduser -g ${PHPGROUP} -s /bin/sh -D ${PHPUSER}

RUN sed -i "s/user = www-data/user = ${PHPUSER}/g" /usr/local/etc/php-fpm.d/www.conf
RUN sed -i "s/group = www-data/group = ${PHPGROUP}/g" /usr/local/etc/php-fpm.d/www.conf

ADD https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/
RUN chmod +x /usr/local/bin/install-php-extensions

RUN mkdir -p /var/www/html/public

WORKDIR /var/www/html

RUN install-php-extensions gd json pdo pdo_mysql mysqli sodium zip json gettext exif zlib fileinfo mbstring

RUN docker-php-source delete

ADD docker/opcache.ini /usr/local/etc/php/conf.d/opcache.ini

CMD ["php-fpm", "-y", "/usr/local/etc/php-fpm.conf", "-R"]