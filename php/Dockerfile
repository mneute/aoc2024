FROM php:8.4-cli

WORKDIR /srv/app

RUN mv "$PHP_INI_DIR/php.ini-development" "$PHP_INI_DIR/php.ini"
COPY docker-php-custom.ini "$PHP_INI_DIR/conf.d/"

ADD --chmod=0755 https://github.com/mlocati/docker-php-extension-installer/releases/latest/download/install-php-extensions /usr/local/bin/

RUN install-php-extensions ds
