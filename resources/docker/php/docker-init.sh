#!/bin/bash

# Setup .env file
if [ -f ".env" ]; then
echo ".env file exists - skipping\n"
else
    cp .env.example .env
fi

# Setup Storage Folders
composer run create-storage-folders
chmod -R 777 storage

# Update Composer
composer update

# Database
php artisan migrate:refresh --database=mysql
for FILE in ./resources/database/seeders/*.*
do
    classname="${FILE##*/}"
    php artisan db:seed --force --database='mysql' --class="Database\\Seeders\\${classname%.*}"
done
