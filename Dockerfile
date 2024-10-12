# Use the official PHP Apache image as base
FROM php:8.3-apache

# Install system dependencies
RUN apt-get update && \
    apt-get install -y \
        libfreetype6-dev \
        libjpeg62-turbo-dev \
        libpng-dev \
        libzip-dev \
        zip \
        unzip \
        vim \
        git \
        nano \
        curl \
        wget \
        libonig-dev \
        libxml2-dev \
        libmcrypt-dev \
        libwebp-dev \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo_mysql mysqli gd mbstring zip exif pcntl bcmath opcache soap

RUN apt-get update \
    && apt-get install -y libpq-dev \
    && docker-php-ext-install pdo pdo_pgsql

RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

# Enable Apache modules
RUN a2enmod rewrite

# Set recommended PHP.ini settings
COPY custom-php.ini /usr/local/etc/php/php.ini

# Update Apache configuration with document root
RUN sed -ri -e 's!/var/www/html!/var/www/html!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!/var/www/html!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf
# Enable the virtual host
RUN ln -s /etc/apache2/sites-available/laravel.test.com.conf /etc/apache2/sites-enabled/

# Expose port 80
EXPOSE ${APACHE_HOST_PORT}

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Set working directory
WORKDIR /var/www/html

RUN chmod 777 -R /var/www/html





