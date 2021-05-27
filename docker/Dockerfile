FROM mattrayner/lamp:latest-1804

WORKDIR /var/www/html/

RUN wget https://raw.githubusercontent.com/composer/getcomposer.org/76a7060ccb93902cd7576b67264ad91c8a2700e2/web/installer -O - -q | php
COPY composer.phar /var/www/html/composer.phar
COPY composer.json /var/www/html/composer.json
RUN php composer.phar update

CMD ["/run.sh"]
