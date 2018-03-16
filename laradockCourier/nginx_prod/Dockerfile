FROM nginx:alpine

MAINTAINER Mahmoud Zalt <mahmoud@zalt.me>

ADD nginx.conf /etc/nginx/

ARG PHP_UPSTREAM_CONTAINER=php-fpm
ARG PHP_UPSTREAM_PORT=9000

RUN apk update \
    && apk upgrade \
    && apk add --no-cache bash \
    && adduser -D -H -u 1000 -s /bin/bash www-data

# Set upstream conf and remove the default conf
RUN echo "upstream php-upstream { server ${PHP_UPSTREAM_CONTAINER}:${PHP_UPSTREAM_PORT}; }" > /etc/nginx/conf.d/upstream.conf \
    && rm /etc/nginx/conf.d/default.conf

# install openssl
RUN apk add --no-cache openssl

# create a folder for the keys
RUN mkdir /etc/nginx/ssl 2> /dev/null

# generate the keys for your local domain
RUN openssl genrsa -out "/etc/nginx/ssl/{SITE_NAME}.key" 2048 \
    && openssl req -new -key "/etc/nginx/ssl/{SITE_NAME}.key" -out "/etc/nginx/ssl/{SITE_NAME}.csr" -subj "/CN={SITE_NAME}/O={SITE_NAME}/C=UK" \
    && openssl x509 -req -days 365 -in "/etc/nginx/ssl/{SITE_NAME}.csr" -signkey "/etc/nginx/ssl/{SITE_NAME}.key" -out "/etc/nginx/ssl/{SITE_NAME}.crt"

CMD ["nginx"]

EXPOSE 80 443
