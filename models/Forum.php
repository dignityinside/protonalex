<?php

namespace app\models;

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "forum".
 *
 * @author Alexander Schilling
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $created
 * @property int $updated
 * @property string $user_id
 * @property int $status_id
 * @property int $category_id
 * @property string $hits
 * @property int $allow_comments
 * @property string $meta_keywords
 * @property string $meta_description
 */
class Forum extends ActiveRecord
{

    /** @var int */
    const MATERIAL_ID = 5;

    /** @var int */
    const STATUS_PUBLIC = 1;

    /** @var int */
    const STATUS_HIDDEN = 0;

    /** @var array */
    const STATUS = [
        self::STATUS_PUBLIC => 'Опубликована',
        self::STATUS_HIDDEN  => 'Не опубликованна',
    ];

    /** @var string */
    const SCENARIO_CREATE = 'create';

    /** @var string */
    const SCENARIO_UPDATE = 'update';

    /** @var string */
    const SCENARIO_ADMIN = 'admin';

    /** @var string Count of all comments */
    public $commentsCount = 0;

    /**
     * Table name
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'forum';
    }

    /**
     * Validation rules
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'created', 'user_id', 'category_id'], 'required'],
            [['content'], 'string'],
            [['created', 'updated', 'user_id', 'status_id', 'category_id', 'hits', 'allow_comments'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['title'], 'string', 'max' => 69],
            [['meta_keywords'], 'string', 'max' => 256],
            [['meta_description'], 'string', 'max' => 156],
        ];
    }

    /**
     * Scenarios
     *
     * @inheritdoc
     */
    public function scenarios()
    {

        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = [
            'title',
            'content',
            'category_id',
            'hits',
            'allow_comments'
        ];

        $scenarios[self::SCENARIO_UPDATE] = [
            'title',
            'content',
            'category_id',
            'hits',
            'allow_comments',
        ];

        $scenarios[self::SCENARIO_ADMIN] = [
            'title',
            'content',
            'status_id',
            'category_id',
            'hits',
            'allow_comments',
            'meta_keywords',
            'meta_description'
        ];

        return $scenarios;

    }

    /**
     * Attribute labels
     *
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название темы',
            'content' => 'Содержание',
            'created' => 'Дата публикации',
            'updated' => 'Дата обновления',
            'user_id' => 'ID Автора',
            'status_id' => 'Статус',
            'category_id' => 'Раздел',
            'hits' => 'Просмотры',
            'allow_comments' => 'Разрешить отвечать на тему',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description'
        ];
    }

    /**
     * Find
     *
     * {@inheritdoc}
     *
     * @return ForumQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new ForumQuery(get_called_class());
    }

    /**
     * Returns user
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Return category
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])
            ->andOnCondition(['material_id' => Category::MATERIAL_FORUM]);
    }

    /**
     * Return status label
     *
     * @return mixed
     */
    public function getStatusLabel()
    {
        return ArrayHelper::getValue(self::STATUS, $this->status_id);
    }

    /**
     * Count hits
     */
    public function countViews()
    {

        global $_COOKIE;

        $name_cookies = \Yii::$app->name . '-views-forum-' . $this->id;
        $expire = 2592000; // days
        $slug = '/forum/' . $this->id;
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
     * Before save
     *
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert): bool
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {

            if (isset(\Yii::$app->user->id)) {
                $this->user_id = \Yii::$app->user->id;
            }

            if (empty($this->created)) {
                $this->created = time();
            }

            if (empty($this->allow_comments)) {
                $this->allow_comments = self::STATUS_PUBLIC;
            }

            $this->hits = 0;

            if (empty($this->category_id)) {
                $this->category_id = 0;
            }

        }

        $this->updated = time();

        if (!UserPermissions::canAdminForum()) {
            $this->status_id = \Yii::$app->params['forum']['preModeration'] ? self::STATUS_HIDDEN : self::STATUS_PUBLIC;
        }

        return true;

    }
}
