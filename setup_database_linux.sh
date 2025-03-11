#!/usr/bin/bash
php artisan migrate
php artisan laravolt:indonesia:seed
php artisan db:seed --class=AgamaSeeder
php artisan db:seed --class=CareersSeeder
echo 'setup selesai'

