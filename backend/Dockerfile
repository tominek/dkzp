FROM php:7.2-apache
WORKDIR /var/www

RUN apt-get update \
 && apt-get install -y git zlib1g-dev \
 && rm -rf /var/lib/apt/lists/* \
 && docker-php-ext-install opcache zip pdo pdo_mysql \
 && a2enmod rewrite headers

COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY ./docker /
COPY composer.json \
  composer.lock \
  symfony.lock \
  ./
RUN composer install --no-scripts \
  && chmod +x /usr/local/bin/app-run
COPY . .
ENTRYPOINT ["app-run"]
CMD ["apache2-foreground"]
