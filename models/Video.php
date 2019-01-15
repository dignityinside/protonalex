<?php

namespace app\models;

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use \yii\db\ActiveRecord;

/**
 * This is the model class for table "video".
 *
 * @author Alexander Schilling
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $code
 * @property string $platform
 * @property string $thumbnail
 * @property int $published
 * @property string $author
 * @property int $user_id
 * @property int $status_id
 * @property int $category_id
 * @property int $hits
 * @property string $language
 * @property int $allow_comments
 * @property string $meta_description
 * @property string $meta_keywords
 */
class Video extends ActiveRecord
{

    /** @var int */
    const MATERIAL_ID = 3;

    /** @var int */
    const STATUS_PUBLIC = 1;

    /** @var int */
    const STATUS_HIDDEN = 0;

    /** @var array */
    const STATUS = [
        self::STATUS_PUBLIC => 'Опубликован',
        self::STATUS_HIDDEN  => 'Не опубликованно',
    ];

    /** @var string */
    const PLATFORM_YOUTUBE = 'youtube';

    /** @var array */
    const PLATFORM = [
        self::PLATFORM_YOUTUBE => 'YouTube'
    ];

    /** @var string */
    const SCENARIO_CREATE = 'create';

    /** @var string */
    const SCENARIO_UPDATE = 'update';

    /** @var string */
    const SCENARIO_ADMIN = 'admin';

    /** @var array */
    const LANGUAGE = [
        0 => 'Русский',
        1 => 'Английский',
    ];

    /** @var string Count of all comments */
    public $commentsCount = 0;

    /**
     * Table name
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'video';
    }

    /**
     * Validation rules
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'code', 'published', 'author'], 'required'],
            [['description', 'code', 'platform', 'thumbnail', 'language'], 'string'],
            [['title', 'author'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['status_id', 'published', 'user_id', 'category_id', 'hits', 'allow_comments'], 'integer'],
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
            'description',
            'code',
            'platform',
            'thumbnail',
            'allow_comments',
            'category_id',
            'author',
            'language'
        ];

        $scenarios[self::SCENARIO_UPDATE] = [
            'title',
            'description',
            'code',
            'platform',
            'thumbnail',
            'allow_comments',
            'category_id',
            'author',
            'language'
        ];

        $scenarios[self::SCENARIO_ADMIN] = [
            'title',
            'description',
            'code',
            'platform',
            'thumbnail',
            'allow_comments',
            'status_id',
            'category_id',
            'author',
            'meta_keywords',
            'meta_description',
            'language'
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
            'title' => 'Название',
            'description' => 'Описание',
            'code' => 'Код видео',
            'published' => 'Дата публикации',
            'author' => 'Автор видео',
            'status_id' => 'Статус',
            'platform' => 'Платформа',
            'thumbnail' => 'Картинка',
            'user_id' => 'ID автора',
            'category_id' => 'Категория',
            'hits' => 'Просмотров',
            'allow_comments' => 'Разрешить комментарии',
            'language' => 'Язык видео'
        ];
    }

    /**
     * Find
     *
     * {@inheritdoc}
     *
     * @return VideoQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new VideoQuery(get_called_class());
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
            ->andOnCondition(['material_id' => Category::MATERIAL_VIDEO]);
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

        $name_cookies = \Yii::$app->name . '-views-video-' . $this->id;
        $expire = 2592000; // days
        $slug = '/video/' . $this->id;
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
     * Before save video
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

            if (empty($this->published)) {
                $this->published = time();
            }

            if (empty($this->allow_comments)) {
                $this->allow_comments = self::STATUS_PUBLIC;
            }

            if (empty($this->author)) {
                $this->author = $this->user->username;
            }

            $this->hits = 0;

            if (empty($this->category_id)) {
                $this->category_id = 0;
            }

        }

        if (!UserPermissions::canAdminVideo()) {
            $this->status_id = \Yii::$app->params['video']['preModeration'] ? self::STATUS_HIDDEN : self::STATUS_PUBLIC;
        }

        return true;

    }
}
