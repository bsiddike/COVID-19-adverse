FROM nginx:stable-alpine

ARG USER
ARG GROUP

ENV NGINXUSER=${USER}
ENV NGINXGROUP=${GROUP}

RUN mkdir -p /var/www/html

ADD docker/vhost.conf /etc/nginx/conf.d/default.conf

RUN sed -i "s/user www-data/user ${NGINXUSER}/g" etc/nginx/nginx.conf

RUN adduser -g ${NGINXGROUP} -s /bin/sh -D ${NGINXUSER}
