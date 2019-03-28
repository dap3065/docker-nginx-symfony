FROM ubuntu:16.04
WORKDIR /usr/share/nginx/html


RUN apt-get clean && apt-get -y update && apt-get install -y locales curl software-properties-common git \
  && locale-gen en_US.UTF-8

RUN LC_ALL=en_US.UTF-8 add-apt-repository ppa:ondrej/php

RUN apt-get update

RUN apt-get install -y php7.2-bcmath php7.2-bz2 php7.2-cli php7.2-common php7.2-curl \
                php7.2-cgi php7.2-dev php7.2-fpm php7.2-gd php7.2-gmp php7.2-imap php7.2-intl \
                php7.2-json php7.2-ldap php7.2-mbstring php7.2-mysql \
                php7.2-odbc php7.2-opcache php7.2-pgsql php7.2-phpdbg php7.2-pspell \
                php7.2-readline php7.2-recode php7.2-soap php7.2-sqlite3 \
                php7.2-tidy php7.2-xml php7.2-xmlrpc php7.2-xsl php7.2-zip \
                php-tideways php-mongodb pecl pear

RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y --no-install-recommends --fix-missing \
    ca-certificates apt-transport-https git zip cron rsyslog nano supervisor postfix mongodb nginx zlib1g-dev libzip-dev

RUN yes | pecl install xdebug \
    && echo "zend_extension=$(find /usr/local/lib/php/extensions/ -name xdebug.so)" > /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_enable=on" >> /usr/local/etc/php/conf.d/xdebug.ini \
    && echo "xdebug.remote_autostart=off" >> /usr/local/etc/php/conf.d/xdebug.ini

RUN docker-php-ext-install mysqli pdo pdo_mysql zip && docker-php-ext-enable mysqli pdo pdo_mysql zip

# install mongodb ext
RUN pecl install mongodb \
    && docker-php-ext-enable mongodb

COPY . /usr/share/nginx/html
COPY nginx.conf /etc/nginx/nginx.conf


RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN cd /usr/share/nginx/html && composer install

# Configure supervisor
COPY supervisord.conf /etc/supervisor/supervisord.conf

CMD ["/usr/bin/supervisord"]