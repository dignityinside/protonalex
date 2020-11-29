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
    'adminAd' => [
        'type' => 2,
        'description' => 'rbac_administrate_ad',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'children' => [
            'adminUsers',
            'adminPost',
            'adminCategory',
            'adminAd',
        ],
    ],
];
