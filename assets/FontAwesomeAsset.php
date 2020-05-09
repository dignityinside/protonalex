<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * FontAwesome asset
 *
 * @package app\assets
 *
 * @author Alexander Schilling
 */
class FontAwesomeAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@bower/font-awesome';

    /** @var string[] */
    public $css = [
        'web-fonts-with-css/css/v4-shims.css',
        'web-fonts-with-css/css/fontawesome-all.css',
    ];
}
