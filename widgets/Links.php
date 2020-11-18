<?php

namespace app\widgets;

use yii\helpers\Html;
use yii\widgets\Menu;

/**
 * Links menu widget
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class Links extends Menu
{

    /** @var string */
    public $faviconUrl = 'http://www.google.com/s2/favicons?domain=';

    /**
     * @inheritdoc
     */
    public function init(): void
    {
        parent::init();

        Html::addCssClass($this->options, 'linksMenu');
    }

    protected function renderItem($item): string
    {
        if (isset($item['url'])) {

            $attributes = [];

            if (isset($item['rel'])) {
                $attributes['rel'] = $item['rel'];
            }

            if (isset($item['target'])) {
                $attributes['target'] = $item['target'];
            }

            $url = '<a href="{url}"';

            foreach ($attributes as $key => $value) {
                $url .= $key . '="' . $value . '" ';
            }

            $url .= 'style="background: no-repeat url(' . $this->getFavIcon($item) . ')">{label}</a>';

            $item['template'] = $url;
        }

        return parent::renderItem($item);
    }

    /**
     * @param array $item
     *
     * @return string
     */
    public function getFavIcon(array $item): string
    {
        $parsedUrl = parse_url($item['url']);

        return isset($parsedUrl['host']) ? $this->faviconUrl . $parsedUrl['host'] : '';
    }
}
