FROM dunglas/frankenphp

RUN install-php-extensions \
    pcntl \
    pdo_mysql \
    	gd \
    	intl \
    	zip \
    	opcache \
        redis

COPY . /app
COPY docker-entrypoint.sh /usr/local/bin/
COPY frankenphp.json /etc/frankenphp.json
COPY php.ini /usr/local/etc/php/conf.d/opcache.ini

ENV FRANKENPHP_CONFIG=/etc/frankenphp.json
RUN chmod +x /usr/local/bin/docker-entrypoint.sh
ENTRYPOINT ["/usr/local/bin/docker-entrypoint.sh"]
