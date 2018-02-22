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
    'admin' => [
        'type' => 1,
        'description' => 'Administrator',
        'children' => [
            'adminUsers',
            'adminPost',
        ],
    ],
];
