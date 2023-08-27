FROM ubuntu:22.04

WORKDIR /var/www/html
ENV TZ=America/Sao_Paulo

RUN ln -snf /usr/share/zoneinfo/$TZ /etc/localtime && echo $TZ > /etc/timezone

RUN apt-get update \
    && apt install tzdata \
    && apt install software-properties-common -y \
    && add-apt-repository ppa:ondrej/php \
    && apt update -y \
    && apt install -y \
    apache2 \
    php7.4 \
    libapache2-mod-php7.4 \
    php7.4-mysql \
    php7.4-mbstring \
    php7.4-curl \
    php7.4-xml \
    php7.4-bcmath \
    php7.4-gd \
    php7.4-ldap \
    # php7.4-opcache \
    net-tools \
    iputils-ping \
    nano 

COPY . .

COPY ./config_apache/sites/dev.local.conf /etc/apache2/sites-available
COPY ./config_apache/apache2.conf /etc/apache2
COPY ./config_apache/php.ini /etc/php/7.4/apache2

RUN a2dissite 000-default.conf \
    default-ssl.conf \
    && a2ensite dev.local.conf \
    && a2enmod rewrite \
    && a2enmod ssl

EXPOSE 80 443

CMD ["apachectl", "-D", "FOREGROUND"]
