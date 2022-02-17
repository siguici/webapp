FROM php:8.0-apache
WORKDIR /public_html
ADD . .
EXPOSE 80
COPY --from=composer /usr/bin/composer /usr/bin/composer
RUN composer install --no-dev
RUN apt-get update -yqq &&\
    apt-get upgrade -yqq &&\
    apt-get install -y nodejs &&\
    npm i -g npm@latest yarn@latest
RUN composer install --no-dev && composer run app;\
    yarn install && yarn run app
