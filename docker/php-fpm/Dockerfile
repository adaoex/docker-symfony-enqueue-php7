FROM php:7-fpm-alpine

COPY wait-for-it.sh /usr/bin/wait-for-it

ENV COMPOSER_ALLOW_SUPERUSER=1

RUN chmod +x /usr/bin/wait-for-it

RUN apk --update --no-cache add git

RUN apk add bash

RUN apk add curl && apk add --update supervisor

RUN docker-php-ext-install pdo_mysql

COPY --from=composer /usr/bin/composer /usr/bin/composer

WORKDIR /var/www

USER root

# Add AMQP extension
RUN apk add --no-cache rabbitmq-c-dev && \
    mkdir -p /usr/src/php/ext/amqp && \
    curl -fsSL https://pecl.php.net/get/amqp | tar xvz -C "/usr/src/php/ext/amqp" --strip 1 && \
    docker-php-ext-install amqp

# Add Kafka extension
RUN apk add librdkafka-dev && \
	mkdir -p /usr/src/php/ext/rdkafka && \
    curl -fsSL https://pecl.php.net/get/rdkafka | tar xvz -C "/usr/src/php/ext/rdkafka" --strip 1 && \
    docker-php-ext-install rdkafka && \
    mkdir -p /etc/supervisor.d/ && \
    chown -R www-data:root /var/log

#RUN /usr/bin/composer install

#RUN /usr/bin/supervisord --configuration /etc/supervisord.conf

#COPY ../supervisor/supervisord_alpine.conf /etc/supervisor.d/

CMD ["/usr/bin/supervisord", "--nodaemon", "--configuration", "/etc/supervisord.conf"]

#CMD composer install ; php-fpm

EXPOSE 9000
