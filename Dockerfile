FROM python:3.6.7
LABEL maintainer "user <user@example>"

RUN \
  echo "deb http://ftp.de.debian.org/debian stretch main" >> /etc/apt/sources.list && \
  apt-get update && \
  apt-get install -y php7.0 && \
  apt-get clean -y

RUN \
  pip3 install numpy pillow tensorflow
