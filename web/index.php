<?php

$development = file_exists(__DIR__ . '/../config/web-local.php');

defined('YII_DEBUG') or define('YII_DEBUG', $development);
defined('YII_ENV') or define('YII_ENV', $development ? 'dev' : 'prod');

require(__DIR__ . '/../vendor/autoload.php');
require(__DIR__ . '/../vendor/yiisoft/yii2/Yii.php');

if ($development) {
    $config = yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../config/common.php'),
        require(__DIR__ . '/../config/web.php'),
        require(__DIR__ . '/../config/web-local.php')
    );
} else {
    $config = yii\helpers\ArrayHelper::merge(
        require(__DIR__ . '/../config/common.php'),
        require(__DIR__ . '/../config/web.php')
    );
}

(new yii\web\Application($config))->run();
