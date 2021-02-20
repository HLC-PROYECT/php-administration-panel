FROM php:8.0-fpm-alpine

LABEL org.label-schema.name="hlc.php.ap"
LABEL org.label-schema.vendor="hlc.ap"
LABEL org.label-schema.description="Docker para la calse de hlc"
LABEL org.label-schema.github="https://github.com/HLC-PROYECT/php-administration-panel"

ARG TZ='Europe/Madrid'

ENV ENVIRONMENT development
ENV TZ ${TZ}

RUN apk add --update --no-cache nginx runit bash curl tzdata autoconf g++ make
RUN pecl install xdebug
RUN docker-php-ext-install pdo pdo_mysql mysqli
RUN docker-php-ext-enable xdebug mysqli
RUN ln -s /usr/share/zoneinfo/$TZ /etc/localtime

# Services

ADD docker/service /etc/service
RUN chmod +x /etc/service/nginx/run && chmod +x /etc/service/php-fpm/run

# Config files
COPY docker/nginx/default.conf /etc/nginx/conf.d/default.conf
COPY docker/nginx/nginx.conf /etc/nginx/nginx.conf
COPY docker/conf/docker.conf /usr/local/etc/php-fpm.d/docker.conf
COPY docker/php/php.ini /usr/local/etc/php/
COPY docker/php/xdebug.ini /usr/local/etc/php/conf.d/
COPY app /app


EXPOSE 80
EXPOSE 9000

CMD ["runsvdir", "/etc/service"]