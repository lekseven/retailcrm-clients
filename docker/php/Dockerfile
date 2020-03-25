FROM php:7.4-fpm

# Install PHP extensions
ADD https://raw.githubusercontent.com/mlocati/docker-php-extension-installer/master/install-php-extensions /usr/local/bin/
RUN chmod uga+x /usr/local/bin/install-php-extensions && sync && \
    install-php-extensions \
    gd xdebug apcu ctype curl dom iconv \
    imagick json intl mcrypt fileinfo mbstring opcache openssl \
    pdo pdo_pgsql pgsql xml zlib phar tokenizer session zip xmlwriter

# Install Composer
RUN echo "$(curl -sS https://composer.github.io/installer.sig) -" > composer-setup.php.sig \
    && curl -sS https://getcomposer.org/installer | tee composer-setup.php | sha384sum -c composer-setup.php.sig \
    && php composer-setup.php && rm composer-setup.php* \
    && chmod +x composer.phar && mv composer.phar /usr/bin/composer

COPY clients.retailcrm.ini /etc/php7/conf.d/
COPY clients.retailcrm.ini /etc/php7/cli/conf.d/
COPY xdebug.ini  /etc/php7/conf.d/

COPY clients.retailcrm.pool.conf /etc/php7/php-fpm.d/

# Install Symfony CLI
RUN apt-get update && apt-get install -y \
    git wget unzip
RUN wget https://get.symfony.com/cli/installer -O - | bash
RUN mv /root/.symfony/bin/symfony /usr/local/bin/symfony

CMD ["php-fpm"]

#RUN addgroup --gid 1000 symfony
RUN adduser --gid 1000 --uid 1000 --disabled-password --quiet symfony
USER symfony

WORKDIR /var/www/clients.retailcrm

EXPOSE 9000
