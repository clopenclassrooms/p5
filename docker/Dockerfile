FROM mattrayner/lamp:latest-1804


RUN mkdir -p /var/www/html/vendor/
WORKDIR /var/www/html/vendor/

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php
COPY composer.phar /var/www/html/vendor/composer.phar
COPY composer.json /var/www/html/vendor/composer.json
RUN php composer.phar update
RUN apt-get install -y --no-install-recommends nano=5.8
CMD ["/run.sh"]
