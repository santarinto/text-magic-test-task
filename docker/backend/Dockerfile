FROM php:cli-alpine

RUN apk --no-cache update \
    && apk --no-cache upgrade \
    && apk add --no-cache --virtual \
      .build-deps \
      curl \
      postgresql-dev \
      libxml2-dev \
      oniguruma-dev \
    && curl -sS https://getcomposer.org/installer | php \
    && chmod +x composer.phar && mv composer.phar /usr/local/bin/composer

RUN docker-php-ext-install \
    pdo \
    pdo_pgsql \
    mbstring \
    posix \
    xml \
    session

WORKDIR /app/
