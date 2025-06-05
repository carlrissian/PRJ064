FROM php:7.4-fpm

#NO MODIFICAR. Valor por defecto si no se pasan argumentos.
ARG XDEBUG_ENV="production"

# Set working directory
WORKDIR /var/www

#Librerias
RUN apt-get update -y && \
    apt-get upgrade -y && \
    apt-get install libpng-dev -y && \
    apt-get install libldap2-dev -y && \
    apt-get install libicu-dev -y && \
    apt-get install zip -y &&\
    apt-get install libzip-dev -y &&\
    apt-get install zip -y

# Install extensions
RUN docker-php-ext-install gd
RUN docker-php-ext-install zip
RUN docker-php-ext-install intl
RUN docker-php-ext-install opcache
RUN docker-php-ext-configure intl

RUN echo 'memory_limit = 512M' >> /usr/local/etc/php/conf.d/docker-php-memlimit.ini;

# Install yarn
RUN apt-get update && \
    apt-get install -y ca-certificates curl gnupg && \
    mkdir -p /etc/apt/keyrings && \
    curl -fsSL https://deb.nodesource.com/gpgkey/nodesource-repo.gpg.key | gpg --dearmor -o /etc/apt/keyrings/nodesource.gpg && \
    NODE_MAJOR=16 && \
    echo "deb [signed-by=/etc/apt/keyrings/nodesource.gpg] https://deb.nodesource.com/node_$NODE_MAJOR.x nodistro main" | tee /etc/apt/sources.list.d/nodesource.list && \
    apt-get update && \
    apt-get install nodejs -y && \
    curl -sS https://dl.yarnpkg.com/debian/pubkey.gpg | apt-key add - && \
    echo "deb https://dl.yarnpkg.com/debian/ stable main" | tee /etc/apt/sources.list.d/yarn.list && \
    apt-get update && \
    apt-get install -y --no-install-recommends yarn && \
    npm install -g npm@7.24.0

# Clear cache
RUN apt-get clean && rm -rf /var/lib/apt/lists/*

# Install composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Copy composer.json
COPY  ./composer.json /composer.lock /var/www/

# Copy yarn files
COPY ./package.json ./package-lock.json ./webpack.config.js yarn.lock /var/www/

# Copy bin console script for @auto-scripts was called via post-install-cmd in composer install
COPY ./bin /var/www/bin/

# Copy config directory
COPY ./config /var/www/config/

# Copy env file
COPY .env.prod /var/www/.env

# Copy source code
COPY ./src /var/www/src/

# Copy Recordgo ERP
COPY ./RecordGo /var/www/RecordGo/

# Copy public directory
COPY ./public /var/www/public/

#RUN chmod 777 /var/www/public
RUN chown -R www-data:www-data /var/www/public

# Copy assets
COPY ./assets /var/www/assets/

# Copy templates
COPY ./templates /var/www/templates/

ENV COMPOSER_ALLOW_SUPERUSER=1
RUN composer install
RUN yarn install
RUN yarn js-routing
RUN yarn dev

# Expose port 9000 and start php-fpm server
EXPOSE 9000
CMD ["php-fpm"]