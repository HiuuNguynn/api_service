FROM wyveo/nginx-php-fpm:php81

RUN apt-key adv --fetch-keys 'https://packages.sury.org/php/apt.gpg' > /dev/null 2>&1
RUN apt-get -y install wget gnupg && \
    wget https://nginx.org/keys/nginx_signing.key && \
    cat nginx_signing.key | apt-key add -

RUN apt-get update && apt-get install vim curl -y && apt-get install netcat -y \
&& apt-get purge -y --auto-remove $buildDeps \
    && apt-get clean \
    && apt-get autoremove \
    && rm -rf /var/lib/apt/lists/*

RUN apt-get update \
    && apt-get install --no-install-recommends --no-install-suggests -q -y php8.1-mongodb

# Set working directory
COPY docker/nginx/app.conf /etc/nginx/conf.d/default.conf
#COPY docker/php/www.conf /etc/php/8.0/fpm/pool.d/www.conf

# worker
COPY docker/supervisord.conf /etc/supervisord.conf
COPY docker/start.sh /start.sh
RUN chmod 755 /start.sh
WORKDIR /usr/share/nginx/html
COPY composer.json ./
#COPY composer.lock ./
RUN composer install -vv --no-interaction --no-scripts --no-dev
COPY . .
COPY .env.example ./.env
RUN cat .env
RUN chmod -R 777 ./docker
RUN composer dump-autoload --optimize
RUN chmod 777 -R /usr/share/nginx/html/storage
RUN chmod 777 -R /usr/share/nginx/html/bootstrap/cache
