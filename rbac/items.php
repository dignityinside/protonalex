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
    'adminVideo' => [
        'type' => 2,
        'description' => 'Administrate video',
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
            'adminVideo',
            'adminForum',
        ],
    ],
];
