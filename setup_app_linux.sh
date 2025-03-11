#!/usr/bin/bash

composer install 
cp .env.example .env
php artisan key:generate
echo ''
echo ''
echo 'Buat Database Dengan MySQL'
echo 'lalu ubah variable DB_DATABASE pada .env file sesuai dengan nama Database yang telah dibuat sebelum nya'
echo 'anda bisa menjalankan setup_database.bat / setup_database.sh'