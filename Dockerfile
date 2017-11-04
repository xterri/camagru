FROM php:7-fpm-alpine
RUN apk --update --upgrade add build-base
RUN \
		apk add postgresql postgresql-dev php5-pgsql \
		&& docker-php-ext-configure pgsql --with-pdo-pgsql=/usr/local/pgsql \
		&& docker-php-ext-install pgsql pdo pdo_pgsql
WORKDIR /app
ENTRYPOINT ["php"]
CMD ["-S", "0.0.0.0:8088"]
EXPOSE 8088
