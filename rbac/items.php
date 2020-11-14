<?php
return [
    'adminPost' => [
        'type' => 2,
        'description' => 'Администрирование записей',
    ],
    'adminUsers' => [
        'type' => 2,
        'description' => 'Администрирование пользователей',
    ],
    'adminCategory' => [
        'type' => 2,
        'description' => 'Администрирование категорий',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'children' => [
            'adminUsers',
            'adminPost',
            'adminCategory',
        ],
    ],
];
