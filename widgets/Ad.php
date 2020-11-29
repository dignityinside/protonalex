<?php

namespace app\widgets;

use app\models\ad\Ad as AdModel;
use yii\base\Widget;
use yii\helpers\Html;

/**
 * Renders ad widget
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class Ad extends Widget
{

    public $slot;

    /**
     * @inheritdoc
     */
    public function run()
    {

        $ads = AdModel::getRandomAd();

        foreach ($ads as $ad) {

            $out = $this->generateSlotContent($ad);

            if ($this->slot == $ad['slot'] && $this->slot == AdModel::SLOT_SIDEBAR) {
                $widget = '<div class="widget"><div class="widget-title">%s</div><div class="widget-content">%s</div></div>';
                return sprintf($widget, 'Реклама', $out);
            }

            if ($this->slot == $ad['slot'] && $this->slot == AdModel::SLOT_POST_BOTTOM) {
                return '<div class="slot_post_bottom"><p>Реклама:</p>' . $out . '</div>';
            }

        }

        return '';

    }

    /**
     * @param array $ad
     * @return string
     */
    private function generateSlotContent(array $ad): string
    {

        if (!empty($ad['code'])) {
            return $ad['code'];
        }

        if ((int) $ad['target_blank'] === 1) {
            $options['target'] = '_blank';
        }

        if ((int) $ad['rel_nofollow'] === 1) {
            $options['rel'] = 'nofollow';
        }

        $description = '';

        if (!empty($ad['description'])) {
            $description = '<p>' . $ad['description'] . '</p>';
        }

        if (!empty($ad['banner_img'])) {
            $content = sprintf(
                '<img src="%s" alt="%s" title="%s" class="slot_post_sidebar" />',
                $ad['banner_img'],
                $ad['title'],
                $ad['title']
            );
        } else {
            $content = $ad['title'];
        }

        return $description . Html::a($content, '/go/' . $ad['slug'], $options);

    }
}
