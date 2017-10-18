# Base image
FROM php:rc-apache

# Project variables
ENV PROJECT_NAME randomwinpicker.de
ENV PROJECT_MODS headers macro rewrite ssl

# Apache & PHP variables
ENV APACHE_DIR /var/www/$PROJECT_NAME/
ENV APACHE_CONFDIR /etc/apache2/
ENV PHP_INI_DIR /usr/local/etc/php/

# Create Apache directory and copy the files
RUN mkdir -p $APACHE_DIR
COPY dist/randomwinpicker.de "$APACHE_DIR/"

# Copy Apache and PHP config files
COPY docker/conf/apache/cert/* "/etc/ssl/certs/"
COPY docker/conf/apache/conf/* "$APACHE_CONFDIR/conf-available/"
COPY docker/conf/apache/site/* "$APACHE_CONFDIR/sites-available/"
COPY docker/conf/php/* "$PHP_INI_DIR/"

# Enable mods, config and site
RUN a2enmod $PROJECT_MODS
RUN a2enconf $PROJECT_NAME
RUN rm $APACHE_CONFDIR/sites-enabled/*
RUN a2ensite $PROJECT_NAME

# Update and upgrade
RUN \
    apt-get update && \
    apt-get -y upgrade

# Enable extensions
RUN apt-get install -y \
    libfreetype6-dev \
    libpng-dev \
    libpq-dev \
    libsodium-dev \
    php-gd \
    php-libsodium \
    && docker-php-ext-configure \
    gd --with-freetype-dir=/usr/include/ \
    && docker-php-ext-install \
    gd \
    pdo_pgsql \
    sodium

# Update workdir to server files' location
WORKDIR $APACHE_DIR/server
