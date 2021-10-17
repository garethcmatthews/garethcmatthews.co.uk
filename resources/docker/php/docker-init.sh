#!/bin/bash

# Setup Storage Folders
composer run create-storage-folders
chmod -R 777 storage

# Update Composer
composer update

# Update Npm
npm install

# Database
php artisan migrate:refresh --database=mysql
for FILE in ./resources/database/seeders/*.*
do
    classname="${FILE##*/}"
    php artisan db:seed --force --database='mysql' --class="Database\\Seeders\\${classname%.*}"
done
