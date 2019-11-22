# Base image
FROM node:buster@sha256:0809b7a2b06d8673d4f24a0259e18178c76187924ca31cb70a1f460b8ac127fd AS stage_build

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
FROM php:7.3-fpm-alpine@sha256:41991ab13201649b42c87eec2fc787e0cf3dadd7ae8dff657a9a816393460dbe AS stage_serve

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
    gd --with-freetype-dir=/usr/include/ \
    && docker-php-ext-install \
    gd \
    pdo_pgsql

# Copy built source files, changing the server files' owner
COPY --chown=www-data:www-data --from=stage_build /app/dist/$PROJECT_NAME/ /var/www/$PROJECT_NAME/

# Copy PHP configuration files
COPY ./docker/php/php.ini $PHP_INI_DIR/
COPY --chown=www-data:www-data ./docker/php/prepend.php $PHP_INI_DIR/

# Declare required mount points
VOLUME /var/www/credentials/$PROJECT_NAME.env

# Update workdir to server files' location
WORKDIR /var/www/$PROJECT_NAME/
