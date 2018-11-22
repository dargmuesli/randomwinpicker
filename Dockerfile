# Base image
FROM node:stretch AS stage_node

# Update and upgrade
RUN \
    apt-get update && \
    apt-get install -y php7.0 php-gd php7.0-zip composer

WORKDIR /app

# Import project files
COPY ./ /app/

# Install Gulp and build project
RUN yarn global add gulp-cli
RUN yarn add gulp@4 -D
RUN gulp build

# Base image
FROM php:apache AS stage_apache

# Project variables
ENV PROJECT_NAME randomwinpicker
ENV PROJECT_MODS headers macro rewrite ssl

# Apache & PHP variables
ENV APACHE_DIR /var/www/$PROJECT_NAME
ENV APACHE_CONFDIR /etc/apache2
ENV PHP_INI_DIR /usr/local/etc/php

# Enable extensions
RUN apt-get update \
    && apt-get install -y \
    libfreetype6-dev \
    libpng-dev \
    libpq-dev \
    && docker-php-ext-configure \
    gd --with-freetype-dir=/usr/include/ \
    && docker-php-ext-install \
    gd \
    pdo_pgsql

# Create Apache directory and copy the files
RUN mkdir -p $APACHE_DIR
COPY --from=stage_node /app/dist/$PROJECT_NAME $APACHE_DIR/

# Change server files' owner
RUN chown www-data:www-data -R $APACHE_DIR/server

# Copy Apache and PHP config files
COPY docker/$PROJECT_NAME/certificates/* /etc/ssl/certificates/
COPY docker/$PROJECT_NAME/apache/conf/* $APACHE_CONFDIR/conf-available/
COPY docker/$PROJECT_NAME/apache/site/* $APACHE_CONFDIR/sites-available/
COPY docker/$PROJECT_NAME/php/* $PHP_INI_DIR/

# Enable mods, config and site
RUN a2enmod $PROJECT_MODS
RUN a2enconf $PROJECT_NAME
RUN a2dissite *
RUN a2ensite $PROJECT_NAME

# Update workdir to server files' location
WORKDIR $APACHE_DIR/server
