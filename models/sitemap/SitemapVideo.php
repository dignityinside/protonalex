<?php

namespace app\models\sitemap;

use yii\helpers\Url;
use app\models\Video;
use demi\sitemap\interfaces\Basic;

/**
 * Class SitemapVideo
 *
 * @author Alexander Schilling
 *
 * @package app\models\sitemap
 */
class SitemapVideo extends Video implements Basic
{

    /**
     * @inheritdoc
     */
    public function getSitemapItems($lang = null)
    {
        return [
            // video/index
            [
                'loc'        => Url::to(['/video/index']),
                'lastmod'    => time(),
                'changefreq' => static::CHANGEFREQ_DAILY,
                'priority'   => static::PRIORITY_10
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function getSitemapItemsQuery($lang = null)
    {
        return static::find()
            ->select(['title', 'published', 'id'])
            ->where(['status_id' => Video::STATUS_PUBLIC])
            ->orderBy(['published' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null)
    {
        return Url::to(['/video/watch', 'id' => $this->id], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null)
    {
        return $this->published;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapChangefreq($lang = null)
    {
        return static::CHANGEFREQ_MONTHLY;
    }

    /**
     * @inheritdoc
     */
    public function getSitemapPriority($lang = null)
    {
        return static::PRIORITY_8;
    }
}
