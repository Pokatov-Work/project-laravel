<?php

use \SleepingOwl\Admin\Navigation\Page;

return [
    [
        'id' => 'forms',
        'title' => 'Формы',
        'icon' => 'fa fa-group',
        'priority' =>'10',
        'pages' => [
            (new Page( \App\Models\forms\FormCooperation::class))
                ->setIcon('fa fa-group')
                ->setTitle('Сотрудничество')
                ->setPriority(20)
            ,
            (new Page( \App\Models\forms\FormAbout::class))
                ->setIcon('fa fa-group')
                ->setTitle('Обратная связь')
                ->setPriority(20)
        ]
    ],
];
