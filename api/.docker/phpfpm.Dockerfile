FROM aas_php80_cli

RUN apt-get update && apt-get install -y --no-install-recommends  apache2 libapache2-mod-fcgid php8.0-fpm sudo php8.0-xdebug php8.0-ldap
RUN a2enmod proxy_fcgi setenvif fcgid actions alias rewrite headers
RUN a2enconf php8.0-fpm
RUN echo "ServerName localhost" >> /etc/apache2/apache2.conf
COPY php-cli.ini /etc/php/8.0/cli/php.ini
COPY php-fpm.ini /etc/php/8.0/fpm/php.ini

RUN echo "error_reporting = E_ALL" >> /etc/php/8.0/cli/conf.d/20-xdebug.ini; \
    echo "display_startup_errors = On" >> /etc/php/8.0/cli/conf.d/20-xdebug.ini; \
    echo "display_errors = On" >> /etc/php/8.0/cli/conf.d/20-xdebug.ini; \
    echo "xdebug.mode = debug" >> /etc/php/8.0/cli/conf.d/20-xdebug.ini;

RUN useradd -m user && echo "user:user" | chpasswd && adduser user sudo
COPY start.sh /opt/start.sh
RUN chmod ug+x /opt/start.sh
ENTRYPOINT [ "/opt/start.sh" ]
