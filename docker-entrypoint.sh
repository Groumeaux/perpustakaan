#!/bin/bash

# Start MySQL service
service mysql start

# Initialize the database if it doesn't already exist
if [ ! -d "/var/lib/mysql/mydb" ]; then
    echo "Initializing MySQL database..."
    mysql -e "CREATE DATABASE mydb;"
    mysql -e "CREATE USER 'user'@'%' IDENTIFIED BY 'password';"
    mysql -e "GRANT ALL PRIVILEGES ON mydb.* TO 'user'@'%';"
    mysql -e "FLUSH PRIVILEGES;"
    
    # Import the SQL file into the database
    if [ -f /docker-entrypoint-initdb.d/data_perpus.sql ]; then
        echo "Importing database from db_export.sql..."
        mysql -u root mydb < /docker-entrypoint-initdb.d/data_perpus.sql
    else
        echo "No SQL dump file found to import."
    fi
fi

# Start Apache
apache2-foreground