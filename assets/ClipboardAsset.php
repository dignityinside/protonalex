<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Clipboard asset
 *
 * @package app\assets
 *
 * @author Alexander Schilling
 */
class ClipboardAsset extends AssetBundle
{

    /** @var string */
    public $sourcePath = '@npm/clipboard';

    /** @var array */
    public $js = [
        'dist/clipboard.js',
    ];

    /** @var string[] */
    public $depends = [
        'yii\web\JqueryAsset',
    ];
}
