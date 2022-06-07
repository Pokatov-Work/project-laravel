<?php

use \SleepingOwl\Admin\Navigation\Page;

return [
    [
        'id' => 'dashboard',
        'title' => 'Dashboard',
        'icon'  => 'fas fa-tachometer-alt',
        'url'   => route('admin.dashboard'),
        'priority' =>'10',
    ],
    (new Page(\Onessa5\Onessa5Core\Models\SiteLayout::class))
        ->setIcon('fa fa-group')
        ->setTitle('Layout')
        ->setPriority(20)
    ,
    [
        'id' => 'pages',
        'title' => 'Страницы',
        'icon' => 'fa fa-group',
        'priority' =>'10',
        'pages' => [
            (new Page( \Onessa5\Onessa5Core\Models\PageTree::class))
                ->setIcon('fa fa-group')
                ->setTitle('Дерево')
                ->setPriority(20)
            ,
            (new Page( \Onessa5\Onessa5Core\Models\Page::class))
                ->setIcon('fa fa-group')
                ->setTitle('Таблица')
                ->setPriority(20)
            ,

        ]
    ],

    [
        'id' => 'configurations',
        'title' => 'Настройки',
        'icon' => 'fa fa-group',
        'priority' =>'20',
        'pages' => [
            [
                'title' => 'Пользователи',
                'icon'  => 'fas fa-users',
                'pages' => [
                    (new Page('\\App\\Models\\User'))
                        ->setIcon('fa fa-users')
                        ->setPriority(10),
                    (new Page('\\App\\Models\\Role'))
                        ->setIcon('fa fa-group')
                        ->setPriority(100),
                    ]
            ],
            (new Page(  \Onessa5\Onessa5Core\Models\SiteSetting::class))
                ->setIcon('fa fa-group')
                ->setTitle('Настройки')
                ->setPriority(10),
            [
                'title' => 'Modules',
                'icon'  => 'fas fa-info-circle',
                'url'   => route('admin.information'),
            ],
            [
                'title' => 'Logs',
                'icon'  => 'fas fa-info-circle',
                'url'   => route('admin.logs'),
            ],
            [
                'title' => 'Git',
                'icon'  => 'fas fa-info-circle',
                'url'   => route('admin.information'),
            ],
            [
                'title' => 'Information',
                'icon'  => 'fas fa-info-circle',
                'url'   => route('admin.information'),
            ],

        ],

    ],

];
