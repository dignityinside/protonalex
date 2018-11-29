<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Font-Awesome Asset
 */
class FontAwesomeAsset extends AssetBundle
{

    public $sourcePath = '@bower/font-awesome';

    public $css = [
        'web-fonts-with-css/css/v4-shims.css',
        'web-fonts-with-css/css/fontawesome-all.css',
    ];

}