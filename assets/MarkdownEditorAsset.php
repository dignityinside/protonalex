<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * Markdown editor asset - groups assets for markdown editor
 *
 * @package app\assets
 *
 * @author Alexander Schilling
 */
class MarkdownEditorAsset extends AssetBundle
{

    /** @var string[] */
    public $js = [
        'js\editor.js',
    ];

    /** @var string[] */
    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\CodeMirrorAsset',
        'app\assets\CodeMirrorButtonsAsset',
    ];
}
