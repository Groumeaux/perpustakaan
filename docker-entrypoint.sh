#!/bin/bash

# Start MySQL service
service mysql start

# Initialize the database if it doesn't already exist
if [ ! -d "/var/lib/mysql/data_perpus" ]; then
    echo "Initializing MySQL database..."
    mysql -e "CREATE DATABASE data_perpus;"
    mysql -e "CREATE USER 'root'@'%' IDENTIFIED BY 'passworddb';"
    mysql -e "GRANT ALL PRIVILEGES ON data_perpus.* TO 'root'@'%';"
    mysql -e "FLUSH PRIVILEGES;"
    
    # Import the SQL file into the database
    if [ -f /docker-entrypoint-initdb.d/data_perpus.sql ]; then
        echo "Importing database from db_export.sql..."
        mysql -u root data_perpus < /docker-entrypoint-initdb.d/data_perpus.sql
    else
        echo "No SQL dump file found to import."
    fi
fi

# Start Apache
apache2-foreground