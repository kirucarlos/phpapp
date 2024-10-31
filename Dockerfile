FROM php:8.1-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y gnupg2
RUN curl https://packages.microsoft.com/keys/microsoft.asc | apt-key add -
RUN curl https://packages.microsoft.com/config/ubuntu/21.10/prod.list > /etc/apt/sources.list.d/mssql-release.list
RUN apt-get update
RUN ACCEPT_EULA=Y apt-get -y --no-install-recommends install msodbcsql17 unixodbc-dev
RUN pecl install sqlsrv
RUN pecl install pdo_sqlsrv

RUN docker-php-ext-enable pdo_sqlsrv && docker-php-ext-enable sqlsrv

# Copy the application files to the web server's document root
COPY app/ /var/www/html

# Expose the port for Apache
EXPOSE 80

# Command to run when the container starts
CMD ["apache2-foreground"]