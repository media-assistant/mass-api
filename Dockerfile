FROM php:fpm-alpine

USER root

# Install system dependencies
RUN apk add --update --no-cache \
    libpng-dev \
    jpeg-dev \
    zlib-dev \
    > /dev/null

# Install PHP extensions
RUN docker-php-ext-install \
    pdo_mysql \
    gd \
    > /dev/null

# Set PHP ini vars
COPY php/custom.ini /usr/local/etc/php/conf.d/custom.ini

# Get latest Composer
RUN php -r "readfile('http://getcomposer.org/installer');" | php -- --install-dir=/usr/bin/ --filename=composer > /dev/null

# Add start script
COPY php/start.sh /usr/bin/start.sh

WORKDIR /var/www

CMD [ "sh", "/usr/bin/start.sh" ]