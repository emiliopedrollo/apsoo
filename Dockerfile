FROM php:alpine

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

RUN apk add git \
 && docker-php-ext-configure pcntl --enable-pcntl \
 && docker-php-ext-install pcntl

COPY . /var/www/site
WORKDIR /var/www/site

RUN composer install --no-dev --prefer-dist \
 && touch database/database.sqlite \
 && php artisan migrate:install \
 && php artisan migrate \
 && php artisan db:seed \
 && php artisan storage:link

ENTRYPOINT ["/var/www/site/artisan","serve","--host","0.0.0.0"]

EXPOSE 8000
