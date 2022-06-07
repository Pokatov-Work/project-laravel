<?php
return [
    'adminDirectory' => app_path('Admin'),
    'locale' => 'ru',
    'format' => [
        'date_format' => 'd.m.Y',
        'date_long_format' => 'd.M.Y',
        'date_time_format' => 'd.m.Y H:i:s',
        'number' => [
            'decimals' => '2',
            'dec_point' => ',',
            'thousands_sep' => ' '
        ]
    ],
    'email' => [
        'email' => 'admin@one-touch.ru',
        'noreplay' => 'noreplay@one-touch.ru'
    ],
    'adminLanguages' => [
        'ru' => 'Русский',
        'en' => 'Английский',
        'hu' => 'Венгерский',
        'de' => 'Немецкий',
        'sk' => 'Словацкий',
        ],
    'adminPeriods' => [-1, 0, 1, 2, 3, 4]
];
