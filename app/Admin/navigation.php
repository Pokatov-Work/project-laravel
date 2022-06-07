<?php

use SleepingOwl\Admin\Navigation\Page;
use Illuminate\Support\Facades\Log;

$routeCollection = \Route::getRoutes();

$adminNavigation = [];
$navigationsPath = base_path('admin/navigations');
if(file_exists($navigationsPath)) {

    $files =  preg_grep('~\.(php)$~',scandir($navigationsPath));
    foreach($files as $file) {
        if('.' !== $file && '..' !== $file && '.gitkeep' !== $file) {
             //Log::info('-- NAV FILE ----'.$navigationsPath.'/'.$file);
            $navArray = include $navigationsPath.'/'.$file;
            $retArray = array_merge($adminNavigation,$navArray);
            $adminNavigation = $retArray; // на всякий случай в разные переменные
        }
    }
}


$appAdminNavigation = [

    // Examples
    // [
    //    'title' => 'Content',
    //    'pages' => [
    //
    //        \App\User::class,
    //
    //        // or
    //
    //        (new Page(\App\User::class))
    //            ->setPriority(100)
    //            ->setIcon('fas fa-users')
    //            ->setUrl('users')
    //            ->setAccessLogic(function (Page $page) {
    //                return auth()->user()->isSuperAdmin();
    //            }),
    //
    //        // or
    //
    //        new Page([
    //            'title'    => 'News',
    //            'priority' => 200,
    //            'model'    => \App\News::class
    //        ]),
    //
    //        // or
    //        (new Page(/* ... */))->setPages(function (Page $page) {
    //            $page->addPage([
    //                'title'    => 'Blog',
    //                'priority' => 100,
    //                'model'    => \App\Blog::class
	//		      ));
    //
	//		      $page->addPage(\App\Blog::class);
    //	      }),
    //
    //        // or
    //
    //        [
    //            'title'       => 'News',
    //            'priority'    => 300,
    //            'accessLogic' => function ($page) {
    //                return $page->isActive();
    //		      },
    //            'pages'       => [
    //
    //                // ...
    //
    //            ]
    //        ]
    //    ]
    // ]
];

$r = array_merge($adminNavigation,$appAdminNavigation);
//Log::info('==========all navigations =========='.print_r($r, true));
return $r;
