FROM php:7.2-apache
WORKDIR /var/www

RUN apt-get update \
 && apt-get install -y git zlib1g-dev \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-install opcache zip \
 && a2enmod rewrite

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./docker /
COPY . .
RUN composer install \
  && chmod +x /usr/local/bin/app-run
ENTRYPOINT ["app-run"]
CMD ["apache2-foreground"]
