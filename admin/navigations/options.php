<?php

use \SleepingOwl\Admin\Navigation\Page;

return [
    [
        'id' => 'options',
        'title' => 'Опции',
        'icon' => 'fa fa-group',
        'priority' =>'10',
        'pages' => [
            (new Page( \App\Models\options\MainMenu::class))
                ->setIcon('fa fa-group')
                ->setTitle('Меню')
                ->setPriority(20)
            ,
            (new Page( \App\Models\options\Region::class))
                ->setIcon('fa fa-group')
                ->setTitle('Регионы')
                ->setPriority(20)
            ,
            (new Page( \App\Models\options\Language::class))
                ->setIcon('fa fa-group')
                ->setTitle('Языки')
                ->setPriority(20)
        ]
    ],
];
