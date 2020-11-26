<?php

$params = require(__DIR__ . '/params.php');
$db = require(__DIR__ . '/db.php');

$config = [
    'id' => 'app-console',
    'controllerNamespace' => 'app\commands',
    'components' => [
        'db' => $db,
        'urlManager' => [
            'scriptUrl' => 'http://protonalex.com',
        ],
    ],
    'controllerMap' => [
        'sitemap' => [
            'class' => 'demi\sitemap\SitemapController',
            'modelsPath' => '@app/models/sitemap',
            'modelsNamespace' => 'app\models\sitemap',
            'savePathAlias' => 'web',
            'sitemapFileName' => 'sitemap.xml'
        ],
    ],
    'params' => $params,
];

return $config;
