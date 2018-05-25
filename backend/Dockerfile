FROM php:7.2-apache
WORKDIR /var/www
COPY --from=composer /usr/bin/composer /usr/bin/composer
COPY . .
RUN compsoer install
