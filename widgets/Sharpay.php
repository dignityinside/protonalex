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


        $out = sprintf('<div class="sharpay_widget_simple" data-sharpay="%s" data-limit="3" data-networks="facebook,twitter,vkontakte,odnoklassniki,whatsapp,telegram,email,copy"></div>
<script async src="https://app.sharpay.io/api/script.js"></script>', \Yii::$app->params['sharpayAppId']);

        return $out;

    }
}
