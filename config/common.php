<?php

return [
    'basePath' => dirname(__DIR__),
    'name' => 'rooland',
    'language' => 'ru-RU',
    'sourceLanguage' => 'en-US',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'components' => [
        'authClientCollection' => [
            'class' => 'yii\authclient\Collection',
            'clients' => require(__DIR__ . '/authclients.php'),
        ],
        'authManager' => [
            'class' => 'yii\rbac\PhpManager',
        ],
        'user' => [
            'class' => 'yii\web\User',
            'identityClass' => 'app\models\User',
        ],
        'i18n' => [
            'translations' => [
                'app*' => [
                    'class' => 'yii\i18n\PhpMessageSource',
                    'basePath' => '@app/messages',
                    'fileMap' => [
                        'app' => 'app.php',
                        'app/blog' => 'blog.php',
                        'app/comments' => 'comments.php',
                        'app/category' => 'category.php',
                    ],
                ],
            ],
        ],
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '<_a:(login|logout|signup|auth|request-password-reset|reset-password|contact|search)>' => 'site/<_a>',
                '<_c:[\w\-]+>/<id:\d+>' => '<_c>/view',
                '<_c:[\w\-]+>/update/<id:\d+>' => '<_c>/update',
                '<_c:[\w\-]+>/delete/<id:\d+>' => '<_c>/delete',
                '<_c:[\w\-]+>/<_a:[\w\-]+>/<id:\d+>' => '<_c>/<_a>',
                // tags
                'tag/search' => 'tag/search',
                [
                    'class' => 'app\components\PostUrlRule',
                ]
            ],
            'baseUrl' => 'https://rooland.org',
        ],
        'comment' => require(__DIR__ . '/comments.php'),
    ],
];
