#!/bin/bash

chmod 777 bootstrap/cache;
chmod -R 777 storage;

composer install;

php artisan storage:link;
php artisan key:generate;
chmod -R 777 storage;
chmod -R 777 public/images/uploads;

# Публикация необходимых ресурсов и файлов из пакетов
php artisan vendor:publish --provider="Laravel\Fortify\FortifyServiceProvider";

php artisan vendor:publish --provider="Spatie\Permission\PermissionServiceProvider";

php artisan vendor:publish --provider="Intervention\Image\ImageServiceProviderLaravelRecent";

# Публикация ресурсов из OWL
php artisan vendor:publish --tag=assets

# Публикация ресурсов из Onessa5Core
php artisan vendor:publish --tag=onessa5-core-initial

# Создание таблиц и заполнение данных
php artisan migrate --seed;

