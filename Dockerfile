# Base image
FROM node:buster@sha256:8d2e8a554b6cfa919f71a05f9deeb5eb136cc492faca0e6e091df7f85e953c75 AS stage_build

# Update and install build dependencies
RUN \
    apt-get update && \
    apt-get install -y composer php php-gd php-zip

# Import project files
COPY ./ /app/
WORKDIR /app/

# Install Gulp and build project
RUN yarn global add gulp-cli
RUN yarn add gulp@4 -D
RUN sg www-data "gulp build"

# Base image
FROM php:7.4-fpm-alpine@sha256:05afdd143b8990e4530ff5c0383640fce60d8428a812e78f9bf268dbbeb5fc47 AS development

# Environment variables
ENV PHP_INI_DIR /usr/local/etc/php
ENV PROJECT_NAME randomwinpicker
# ENV PROJECT_MODS headers macro rewrite ssl

# Enable extensions
RUN apk add --no-cache \
    freetype-dev \
    libpng-dev \
    postgresql-dev \
    && docker-php-ext-configure \
    gd --with-freetype=/usr/include/ \
    && docker-php-ext-install \
    gd \
    pdo_pgsql

# Copy built source files, changing the server files' owner
COPY --chown=www-data:www-data --from=stage_build /app/dist/$PROJECT_NAME/ /var/www/$PROJECT_NAME/

# Copy PHP configuration files
COPY --chown=www-data:www-data ./docker/php/* $PHP_INI_DIR/

# Declare required mount points
VOLUME /var/www/$PROJECT_NAME/credentials/$PROJECT_NAME.env

# Update workdir to server files' location
WORKDIR /var/www/$PROJECT_NAME/
