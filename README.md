# Описание проекта
Мультиязычный информационный портал о криптавалюте. Функционал портала позволяет наполнять и управлять 5-ю языковыми версиями 
из одной административной панели.

Графики валют и актуальная стоимость получается и обновляется по API из стороннего ресурса.

### Требования
PHP7.3 и выше
Mysql 8 и выше
Установить nmp, node 12

## Project
Проект создан на базе собственной разработки компании Onessa5 (Core) и устанавливается в проект в виде пакета.
При этом автоматически копируются файлы из пакета Core
Фронт написан на Vue

### Полезные команды

загрузка структуры базы
```
php artisan migrate --seed
php artisan db:seed --class=DatabaseSeeder

```

### При обновлении OWL пакета
```
 php artisan sleepingowl:update

```

### Создание миграции
[Migrations doc](https://laravel.com/docs/8.x/migrations#rolling-back-migrations)
Для изменения базы данных необходимо создать файл миграции. Имена таблиц через _
```
php artisan make:migration create_main_menus_table --create=main_menus
```
Откатить полностью
...
php artisan migrate:rollback
...

Все удалить и создать заново
...
php artisan migrate:refresh
...
// Refresh the database and run all database seeds...
...
php artisan migrate:refresh --seed
...

### Внешние
[Логин](https://github.com/laravel/fortify )

[Права](https://spatie.be/docs/laravel-permission/v3/introduction)

[Дерево](https://packagist.org/packages/kalnoy/nestedset)

[Админка](https://sleepingowladmin.ru/#/ru/installation)
