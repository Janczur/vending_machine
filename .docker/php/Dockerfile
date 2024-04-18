FROM php:8.3-cli
ARG TIMEZONE

COPY php.ini /usr/local/etc/php/conf.d/docker-php-config.ini

RUN apt-get update && apt-get install -y \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libicu-dev  \
    libonig-dev \
    libpq-dev \
    && pecl install xdebug \
    && docker-php-ext-enable xdebug

RUN docker-php-ext-install \
    zip intl opcache mbstring

RUN rm -rf /var/lib/apt/lists/* # Clean up unnecessary files and reduce image size

# Set timezone
RUN ln -snf /usr/share/zoneinfo/${TIMEZONE} /etc/localtime && echo ${TIMEZONE} > /etc/timezone \
    && printf '[PHP]\ndate.timezone = "%s"\n', ${TIMEZONE} > /usr/local/etc/php/conf.d/tzone.ini \
    && "date"

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN echo 'alias sf="php bin/console"' >> ~/.bashrc

WORKDIR /var/www/symfony
