FROM php:8.3-apache

COPY public/ /var/www/html/

COPY public/config/apache.conf /etc/apache2/conf-available/custom.conf

RUN a2enconf custom

WORKDIR /var/www/html/

EXPOSE 80
