# Base image
# "buster" for up-2-date php required
# "slim" lacks python, which is required by node-gyp / sass
FROM node:14.5.0-buster@sha256:ed37f8f056f5df4135ff30a5cc8eac10571f134c32a52c2e1bcc68d1433c6c6b AS stage_build

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
RUN gulp build --production


# Base image
FROM php:7.4-fpm-alpine@sha256:ee9b2603d4de104407787b318e428df572e3904e8ecf5a65a488a704bb5b4008 AS development

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
FROM php:7.4-fpm-alpine@sha256:ee9b2603d4de104407787b318e428df572e3904e8ecf5a65a488a704bb5b4008 AS production

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
COPY --chown=www-data:www-data --from=stage_build /app/dist/$PROJECT_NAME/ /usr/src/$PROJECT_NAME/

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