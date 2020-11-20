<?php

namespace app\helpers;

use app\models\post\Post;
use yii\helpers\Html;

/**
 * Text helper
 *
 * @author Alexander Makarov
 * @author Alexander Schilling
 */
class Text
{

    /**
     * Cuts text after [cut|premium] mark
     *
     * @param string $tag
     * @param string $text
     * @param null|string $moreLink
     *
     * @return string
     */
    public static function cut(string $tag, string $text, ?string $moreLink = null): string
    {
        $text = explode($tag, $text, 2);

        return empty($text[1]) ? $text[0] : $moreLink === null ? $text[0] : $text[0] . "\n$moreLink";
    }

    /**
     * Removes [cut|premium] mark from the text
     *
     * @param string $text
     *
     * @return string
     */
    public static function hideCut(string $tag, string $text): string
    {
        return str_replace($tag, '', $text);
    }

    /**
     * Returns tags list
     *
     * @param Post $model
     *
     * @return string
     */
    public static function getTagsList(Post $model)
    {

        $buffer = [];

        foreach ($model->tags as $tag) {
            $buffer[] = Html::a($tag->fName, ['/post/tag', 'tagName' => $tag->slug]);
        }

        return implode(', ', $buffer);
    }
}
