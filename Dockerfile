# Use PHP with Apache as the base image
FROM php:7.4-apache

# Install MySQL and required PHP extensions
RUN apt-get update && \
    DEBIAN_FRONTEND=noninteractive apt-get install -y \
    mysql-server && \
    docker-php-ext-install mysqli && \
    rm -rf /var/lib/apt/lists/*

# Create the uploads directory and set permissions
RUN mkdir -p /var/www/html/images/covers && \
    chown -R www-data:www-data /var/www/html/images/covers && \
    chmod -R 755 /var/www/html/images/covers

# Create the uploads directory and set permissions
RUN mkdir -p /var/www/html/images/profiles && \
    chown -R www-data:www-data /var/www/html/images/profiles && \
    chmod -R 755 /var/www/html/images/profiles

# Copy website files to the Apache root
COPY ./. /var/www/html

# Copy the SQL dump file
COPY ./data_perpus.sql /docker-entrypoint-initdb.d/data_perpus.sql

# Set up the entrypoint script
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Expose Apache and MySQL ports
EXPOSE 80 3306

# Default command
ENTRYPOINT ["docker-entrypoint.sh"]
