# Base image
# "buster" for up-2-date php required
# "slim" lacks python, which is required by node-gyp / sass
FROM node:14.13.1-buster@sha256:8244483d3d1766c2903f64339171ec5e7ff92c0290d8b775bb3257eaa03a9685 AS build

# Update and install build dependencies
RUN \
    apt-get update && \
    apt-get install -y composer php php-gd php-zip

# Import project files
COPY ./ /srv/app/
WORKDIR /srv/app/

# Install Gulp and build project
RUN yarn global add gulp-cli
RUN yarn add gulp@4 -D
RUN gulp build --production


# Base image
FROM php:7.4-fpm-alpine@sha256:82a498133f38af7dffe51cd39923d7c0cfc172cececb519c321e63eae22c42fa AS development

# Environment variables
ENV PHP_INI_DIR /usr/local/etc/php
ENV PROJECT_NAME randomwinpicker

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

# Copy PHP configuration files
COPY --chown=www-data:www-data ./docker/php/* $PHP_INI_DIR/

# Declare required mount points
VOLUME /var/www/$PROJECT_NAME/credentials/$PROJECT_NAME.env

# Update workdir to server files' location
WORKDIR /var/www/$PROJECT_NAME/


# Base image
FROM php:7.4-fpm-alpine@sha256:82a498133f38af7dffe51cd39923d7c0cfc172cececb519c321e63eae22c42fa AS production

# Environment variables
ENV PHP_INI_DIR /usr/local/etc/php
ENV PROJECT_NAME randomwinpicker

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
COPY --chown=www-data:www-data --from=build /srv/app/dist/$PROJECT_NAME/ /usr/src/$PROJECT_NAME/

# Copy PHP configuration files
COPY --chown=www-data:www-data ./docker/php/* $PHP_INI_DIR/

# Copy the entrypoint script to root
COPY ./docker/entrypoint.sh /

# Declare required mount points
VOLUME /var/www/$PROJECT_NAME/credentials/$PROJECT_NAME.env

# Update workdir to server files' location
WORKDIR /var/www/$PROJECT_NAME/

# Specify entrypoint script, that updates the source files in the shared volume (nginx)
ENTRYPOINT ["/entrypoint.sh"]
CMD ["php-fpm"]