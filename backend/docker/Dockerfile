# FROM php:8.0.2-fpm

# RUN apt-get update && apt-get install -y \
#     git \
#     curl \
#     zip \
#     vim \
#     unzip

# # It's in not recommended to install composer with docker,
# # however, since we use this docker-file for beginners we can run this command just in case.
# # It is better to have composer installed on your local machine already.
# RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# RUN docker-php-ext-install pdo pdo_mysql
#docker/php
FROM php:8.2-fpm-buster

RUN apt-get update && apt-get install -y \
    gnupg \
    g++ \
    procps \
    openssl \
    git \
    unzip \
    zlib1g-dev \
    libzip-dev \
    libfreetype6-dev \
    libpng-dev \
    libjpeg-dev \
    libicu-dev  \
    libonig-dev \
    libxslt1-dev \
    acl \
    && echo 'alias sf="php bin/console"' >> ~/.bashrc

RUN docker-php-ext-configure gd --with-jpeg --with-freetype 

RUN docker-php-ext-install \
    pdo pdo_mysql zip xsl gd intl opcache exif mbstring

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

WORKDIR /var/www

