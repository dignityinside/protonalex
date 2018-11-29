<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * ClipboardAsset
 */

/**
 * Class ClipboardAsset
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

    public $depends = [
        'yii\web\JqueryAsset',
    ];

}
