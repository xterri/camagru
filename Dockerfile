FROM php:7-fpm-alpine

ENV PATH /usr/local/go/bin:$PATH
ENV GOPATH /root/go
# apk add sudo go zsh << add if using/installing MailHog
# apk add ssmtp
RUN apk --update --upgrade add build-base sudo go zsh 
RUN \
		apk add postgresql postgresql-dev php5-pgsql curl git libpng-dev \
		&& docker-php-ext-configure pgsql -with-pgsql=/usr/local/pgsql -with-pdo-pgsql=/usr/local/pgsql \
		&& docker-php-ext-install pgsql pdo pdo_pgsql gd \
		&& rm -rf /var/lib/apk/lists/*
# Set up sendmail config. for docker container
#RUN echo "hostname=localhost.localdomain" > /etc/ssmtp/ssmtp.conf
#RUN echo "root=foxypocky8@gmail.com" > /etc/ssmtp/ssmtp.conf
#maildev = name used for link command in docker-compose file
#RUN echo "mailhub=maildev" >> /etc/ssmtp/ssmtp.conf
#set up php sendmail config
#RUN echo "sendmail_path=sendmail -i -t" >> /usr/local/etc/php/conf.d/php-sendmail.ini
#RUN echo "localhost localhost.localdomain" >> /etc/hosts

# Comment out Mailhog + Golang commandsi
RUN curl -Lsf 'https://storage.googleapis.com/golang/go1.8.3.linux-amd64.tar.gz' | sudo tar -C '/usr/local' -xvzf -
RUN go get github.com/mailhog/mhsendmail
RUN cp $HOME/go/bin/mhsendmail /usr/bin/mhsendmail
RUN echo 'sendmail_path = /usr/bin/mhsendmail --smtp-addr mailhog:1025' > /usr/local/etc/php/php.ini
WORKDIR /app
ENTRYPOINT ["php"]
CMD ["-S", "0.0.0.0:8088"]
EXPOSE 8088
