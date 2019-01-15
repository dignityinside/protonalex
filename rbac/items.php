<?php
return [
    'adminPost' => [
        'type' => 2,
        'description' => 'Administrate posts',
    ],
    'adminUsers' => [
        'type' => 2,
        'description' => 'Administrate users',
    ],
    'adminCategory' => [
        'type' => 2,
        'description' => 'Administrate categories',
    ],
    'adminPlanet' => [
        'type' => 2,
        'description' => 'Administrate planet',
    ],
    'adminVideo' => [
        'type' => 2,
        'description' => 'Administrate video',
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'children' => [
            'adminUsers',
            'adminPost',
            'adminCategory',
            'adminPlanet',
            'adminVideo',
        ],
    ],
];
