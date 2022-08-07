FROM existenz/webstack:8.0

RUN apk add --no-cache php8 php8-cli php8-curl php8-intl php8-pdo_mysql php8-session php8-tokenizer php8-phar php8-xmlwriter php8-mbstring php8-simplexml php8-iconv php8-fileinfo php8-dom php8-xml php8-zip php8-openssl php8-pdo_sqlite
RUN apk add --no-cache git
RUN apk add --no-cache composer
RUN apk add --no-cache npm

RUN cp /usr/bin/php8 /usr/bin/php

ARG BUILD_ENV

WORKDIR /

COPY conf/nginx.conf /etc/nginx/nginx.conf
COPY conf/php.ini /etc/php8/php.ini

COPY ./project/laravel /www

RUN if [[ "$BUILD_ENV" == "PRD" ]]; then \
    cd /www && \
    composer install; \
    npm install; \
    npm run dev; \
    fi

RUN if [[ "$BUILD_ENV" == "PRD" ]]; then \
    chown -R php:php /www; \
    fi