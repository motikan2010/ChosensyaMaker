FROM python:3.6.7
LABEL maintainer "user <user@example>"

RUN \
  echo "deb http://ftp.de.debian.org/debian stretch main" >> /etc/apt/sources.list && \
  apt-get update && \
  apt-get install -y zip unzip php7.0 php7.0-gd php-mbstring php-xml && \
  apt-get clean -y

RUN \
  pip3 install numpy pillow tensorflow

ADD ./ /opt/ChosensyaMaker/

WORKDIR /opt/ChosensyaMaker/

RUN \ 
  curl -sS https://getcomposer.org/installer | php && \
  mv composer.phar /usr/local/bin/composer && \
  composer self-update && \
  composer install && \
  php artisan key:generate

ENTRYPOINT ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]

