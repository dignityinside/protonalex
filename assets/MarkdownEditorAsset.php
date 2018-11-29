<?php

namespace app\assets;

use yii\web\AssetBundle;

/**
 * MarkdownEditorAsset groups assets for markdown editor
 */
class MarkdownEditorAsset extends AssetBundle
{

    public $js = [
        'js\editor.js',
    ];

    public $depends = [
        'yii\web\JqueryAsset',
        'app\assets\CodeMirrorAsset',
        'app\assets\CodeMirrorButtonsAsset',
    ];

}