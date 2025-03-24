FROM php:8.4-apache
COPY . /var/www/html
CMD ["apache2-foreground"]


RUN docker-php-ext-install pdo pdo_mysql mysqli