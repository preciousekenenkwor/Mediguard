FROM php:8.1.8 AS php

RUN apt-get update -y && apt-get install -y libmariadb-dev
RUN docker-php-ext-install mysqli pdo pdo_mysql

WORKDIR /var/medicare

COPY . .

RUN chmod +x Docker/entry_point.sh


COPY --from=composer:2.8.2 /usr/bin/composer  /usr/bin/composer

ENV PORT=8000
ENTRYPOINT [ "Docker/entry_point.sh" ]