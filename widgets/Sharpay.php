<?php

namespace app\widgets;

use yii\base\Widget;

/**
 * Render sharpay buttons
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class Sharpay extends Widget
{

    public function run()
    {

        $out = '<script async src="https://app.sharpay.io/api/script.js"></script>';
        $out .= sprintf('<div class="sharpay_widget_button" data-sharpay="%s"></div>', \Yii::$app->params['sharpayAppId']);

        return $out;

    }
}
