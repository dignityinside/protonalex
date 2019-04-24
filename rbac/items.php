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
    'adminDeals' => [
        'type' => 2,
        'description' => 'Administrate deals',
    ],
    'adminForum' => [
        'type' => 2,
        'description' => 'Administrate forum',
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
            'adminDeals',
            'adminForum',
        ],
    ],
];
