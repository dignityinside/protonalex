<?php

namespace app\models\sitemap;

use app\models\Material;
use yii\helpers\Url;
use app\models\post\Post;
use demi\sitemap\interfaces\Basic;

/**
 * Class SitemapPost
 *
 * @author Alexander Schilling
 *
 * @package app\models\sitemap
 */
class SitemapPost extends Post implements Basic
{

    /**
     * @inheritdoc
     */
    public function getSitemapItems($lang = null)
    {
        return [
            // post/index
            [
                'loc'        => Url::to(\Yii::$app->params['site']['url']),
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
            ->select(['title', 'datecreate', 'dateupdate', 'slug'])
            ->where(['status_id' => Material::STATUS_PUBLIC])
            ->orderBy(['datecreate' => SORT_DESC]);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLoc($lang = null)
    {
        return Url::to(['/post/view', 'slug' => $this->slug], true);
    }

    /**
     * @inheritdoc
     */
    public function getSitemapLastmod($lang = null)
    {
        return $this->dateupdate;
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
