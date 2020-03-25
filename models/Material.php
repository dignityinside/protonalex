<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Material model
 *
 * @author Alexander Schilling
 *
 * @package app\models
 */
class Material extends ActiveRecord
{

    /** @var string */
    public const SCENARIO_CREATE = 'create';

    /** @var string */
    public const SCENARIO_UPDATE = 'update';

    /** @var string */
    public const SCENARIO_ADMIN = 'admin';

    /** @var int */
    public const STATUS_DRAFT = 0;

    /** @var int */
    public const STATUS_PUBLIC = 1;

    /** @var int */
    public const MATERIAL_POST_ID = 1;

    /** @var int */
    public const MATERIAL_VIDEO_ID = 3;

    /** @var int */
    public const MATERIAL_DEALS_ID = 4;

    /** @var int */
    public const MATERIAL_FORUM_ID = 5;

    /** @var string */
    public const MATERIAL_POST_NAME = 'Post';

    /** @var string */
    public const MATERIAL_VIDEO_NAME = 'Video';

    /** @var string */
    public const MATERIAL_DEALS_NAME = 'Deals';

    /** @var string */
    public const MATERIAL_FORUM_NAME = 'Forum';

    /** @var array */
    public const MATERIAL_MAPPING = [
        self::MATERIAL_POST_ID => self::MATERIAL_POST_NAME,
        self::MATERIAL_VIDEO_ID => self::MATERIAL_VIDEO_NAME,
        self::MATERIAL_DEALS_ID => self::MATERIAL_DEALS_NAME,
        self::MATERIAL_FORUM_ID => self::MATERIAL_FORUM_NAME,
    ];

    /** @var int Count of all comments */
    public $commentsCount;

    /**
     * Returns list of statuses
     *
     * @return array
     */
    public function getStatuses(): array
    {
        return [
            Material::STATUS_PUBLIC => 'Опубликован',
            Material::STATUS_DRAFT  => 'Черновик',
        ];
    }

    /**
     * Returns status
     *
     * @return null|string
     */
    public function getStatusLabel(): ?string
    {
        return ArrayHelper::getValue($this->getStatuses(), $this->status_id);
    }

    /**
     * Count hits
     *
     * @param string $materialName
     *
     * @return void
     */
    public function countHits(string $materialName): void
    {

        global $_COOKIE;

        $name_cookies = \Yii::$app->name . '-views-' . strtolower($materialName) . '-' . $this->id;
        $expire = 2592000; // days
        $slug = '/' . strtolower($materialName) . '/' . $this->id;
        $all_slug = [];

        if (isset($_COOKIE[$name_cookies])) {
            $all_slug = explode('|', $_COOKIE[$name_cookies]);
        }

        if (in_array($slug, $all_slug)) {
            false;
        } else {
            $all_slug[] = $slug;
            $all_slug = array_unique($all_slug);
            $all_slug = implode('|', $all_slug);
            $expire = time() + $expire;

            @setcookie($name_cookies, $all_slug, $expire);

            $this->updateCounters(["hits" => 1]);
        }
    }

    /**
     * Returns user
     *
     * @return \yii\db\ActiveQuery
     */
    protected function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }
}
