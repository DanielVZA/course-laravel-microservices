FROM php:8.0

RUN apt-get update && apt-get install -y zip unzip

RUN apt-get clean && rm -rf /var/lib/apt/lists/*

RUN docker-php-ext-install pdo pdo_mysql
RUN curl -sS https://getcomposer.org/installer | php -- \
        --install-dir=/usr/local/bin --filename=composer

WORKDIR /app
COPY . .
RUN composer install
