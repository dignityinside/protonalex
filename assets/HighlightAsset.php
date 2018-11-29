<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * App asset
 *
 * @package app\assets
 *
 * @author Alexander Schilling
 */
class HighlightAsset extends AssetBundle
{

    /** @var string */
    public $basePath = '@webroot';

    /** @var string */
    public $baseUrl = '@web';

    /** @var array */
    public $css = [
        'css/highlight/github.css'
    ];

    /** @var array */
    public $js = [
        'js/highlight.js'
    ];

}
