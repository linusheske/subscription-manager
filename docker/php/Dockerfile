FROM php:8.3-fpm-alpine
# Hier wird das offizielle PHP-Image in der Version 8.3

# Diese Zeile führt Befehle aus, um Composer zu installieren,
# ein Tool für die PHP-Abhängigkeitsverwaltung.
# curl wird verwendet, um den Composer-Installer herunterzuladen,
# und php führt diesen Installer aus, um Composer in /usr/local/bin zu installieren.
#Das bedeutet, Composer wird global verfügbar sein.
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer
RUN composer selfupdate

RUN docker-php-ext-install pdo_mysql

# Definiert den Standardbefehl, der ausgeführt wird, wenn der Container startet.
# Hier startet es den php-fpm-Dienst im Vordergrund (-F). PHP-FPM (FastCGI Process Manager) ist ein PHP FastCGI-Manager, der für die Ausführung von PHP-Code und die Kommunikation mit einem Webserver verwendet wird.
CMD ["php-fpm", "-F"]

EXPOSE 9000
# Informiert Docker, dass der Container auf Port 9000 lauscht. Dies ist der Standardport für PHP-FPM. Beachten Sie, dass dies nur den Container intern markiert und keine Ports automatisch nach außen freigibt.