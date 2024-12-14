# Use PHP with Apache as the base image
FROM php:7.4-apache

# Install PHP extensions needed for MySQL
RUN docker-php-ext-install mysqli

# Create two directories for uploads
RUN mkdir -p /var/www/html/images/profiles /var/www/html/images/covers && \
    chown -R www-data:www-data /var/www/html/images/profiles /var/www/html/images/covers && \
    chmod -R 755 /var/www/html/images/profiles /var/www/html/images/covers && \
    chown -R www-data:www-data /var/www/html

# Copy website files (root folder)
COPY ./ /var/www/html/

# Expose Apache port
EXPOSE 80