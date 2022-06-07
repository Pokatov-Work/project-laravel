<?php

use \SleepingOwl\Admin\Navigation\Page;

return [
    [
        'id' => 'news',
        'title' => 'Новости',
        'icon' => 'fa fa-group',
        'priority' =>'10',
        'pages' => [
            (new Page( \App\Models\news\News::class))
                ->setIcon('fa fa-group')
                ->setTitle('Новости')
                ->setPriority(20)
            ,
        ]
    ],
];
