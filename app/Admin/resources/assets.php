<?php

/*
Файл для подключения ресурсов
*/
use KodiCMS\Assets\Facades\PackageManager;
use SleepingOwl\Admin\Facades\Meta;

PackageManager::add('adm-components')
   // ->css('ckeditor.css', asset('css/ckeditor.css'))
//    ->js('components.js', asset('js/components.js'))
;

Meta::setTitle('')
    ->setMetaDescription('admin meta')
  //  ->addJs('admin-default', asset('js/components.js'), ['admin-scripts'])
//    ->addJs('admin-default', asset('js/app.js'), ['admin-scripts'])
//    ->addJs('admin-scripts', route('admin.scripts'))
   // ->addCss('admin-skin', asset('/admin/css/admin.css'))
    ->setFavicon(asset('favicon.ico'));

Meta::loadPackage(['adm-components']);
