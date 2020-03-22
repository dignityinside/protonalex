<?php

namespace app\models\sitemap;

use app\models\Material;
use yii\helpers\Url;
use app\models\forum\Forum;
use demi\sitemap\interfaces\Basic;

/**
 * Class SitemapForum
 *
 * @author Alexander Schilling
 *
 * @package app\models\sitemap
 */
class SitemapForum extends Forum implements Basic
{

    /**
     * @inheritdoc
     */
    public function getSitemapItems($lang = null)
    {
        return [
            // forum/index
            [
                'loc'        => Url::to(['/forum/index']),
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
            ->select(['title', 'created', 'id'])
            ->where(['status_id' => Material::STATUS_PUBLIC])
            ->orderBy(['created' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null)
    {
        return Url::to(['/forum/topic', 'id' => $this->id], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null)
    {
        return $this->created;
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
