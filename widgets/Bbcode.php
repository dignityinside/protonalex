<?php

namespace app\widgets;

use yii\base\Widget;
use Dignity\BBCode as DignityBBCode;

/**
 * Class Bbcode
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class Bbcode extends Widget
{

    public $text;

    /**
     * @inheritdoc
     */
    public function run()
    {
        return DignityBBCode::parse($this->text);
    }

}
