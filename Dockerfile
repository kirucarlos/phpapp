FROM php:8.1-apache

# Install required PHP extensions
RUN apt-get update && apt-get install -y libpq-dev

# Enable PDO PostgreSQL extension
RUN docker-php-ext-install pdo_pgsql

# Copy the application files to the web server's document root
COPY app/ /var/www/html/

# Expose the port for Apache
EXPOSE 80

# Command to run when the container starts
CMD ["apache2-foreground"]
