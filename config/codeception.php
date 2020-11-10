<?php

return yii\helpers\ArrayHelper::merge(
    require __DIR__ . '/common.php',
    require __DIR__ . '/test.php',
    [
        'components' => [
            'request' => [
                'cookieValidationKey' => 'test',
            ],
        ],
    ]
);
