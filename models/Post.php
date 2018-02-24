<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;
use \yii\db\ActiveRecord;
use Dignity\TranslitHelper;

/**
 * This is the model class for table "post".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $slug
 * @property string  $content
 * @property integer $status_id
 * @property integer $datecreate
 * @property integer $dateupdate
 * @property integer $user_id
 * @property integer $hits
 * @property string  $allow_comments
 * @property integer $ontop
 * @property string  $meta_keywords
 * @property string  $meta_description
 * @property string  $tags
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 *
 */
class Post extends ActiveRecord
{

    const STATUS_DRAFT = 0;
    const STATUS_PUBLIC = 1;

    const SHOW_ON_TOP = 1;

    const SCENARIO_CREATE = 'create';
    const SCENARIO_UPDATE = 'update';
    const SCENARIO_ADMIN = 'admin';

    /** @var string Count of all comments */
    public $commentsCount;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['title', 'content', 'datecreate', 'dateupdate', 'user_id', 'hits', 'ontop'], 'required'],
            [['content', 'allow_comments', 'tags', 'slug'], 'string'],
            [['status_id', 'datecreate', 'dateupdate', 'user_id', 'hits', 'ontop'], 'integer'],
            [['title'], 'string', 'max' => 69],
            [['meta_keywords'], 'string', 'max' => 256],
            [['meta_description'], 'string', 'max' => 156],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = [
            'title',
            'content',
            'tags',
            'allow_comments',
            'status_id',
            'slug',
        ];

        $scenarios[self::SCENARIO_UPDATE] = [
            'title',
            'content',
            'tags',
            'allow_comments',
            'status_id',
            'slug',
        ];

        $scenarios[self::SCENARIO_ADMIN] = [
            'title',
            'content',
            'tags',
            'allow_comments',
            'status_id',
            'ontop',
            'meta_keywords',
            'meta_description',
            'slug',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'               => 'ID',
            'title'            => 'Заголовок',
            'content'          => 'Текст',
            'status_id'        => 'Статус',
            'datecreate'       => 'Дата публикации',
            'dateupdate'       => 'Дата обновления',
            'tags'             => 'Тэги',
            'user_id'          => 'ID Автора',
            'hits'             => 'Просмотров',
            'allow_comments'   => 'Разрешить комментарии',
            'ontop'            => 'На главную',
            'meta_keywords'    => 'Ключевые слова (meta-keywords)',
            'meta_description' => 'Описание страницы (meta-description)',
            'slug'             => 'Постоянная ссылка',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    // подсчет количества просмотров
    public function countViews()
    {

        global $_COOKIE;

        $name_cookies = Yii::$app->name . '-views-post-' . $this->id;
        $expire = 2592000; // 30 дней
        $slug = '/post/' . $this->id;
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

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {

            $this->user_id = Yii::$app->user->id;
            $this->datecreate = time();
            $this->dateupdate = time();
            $this->hits = 0;

            if (empty($this->slug)) {
                $this->slug = TranslitHelper::translit($this->title);
            }

        } else {

            $this->dateupdate = time();

            if (empty($this->slug)) {
                $this->slug = TranslitHelper::translit($this->title);
            }

        }

        return true;

    }

    public function getStatusLabel()
    {

        $statuses = self::getStatuses();

        return ArrayHelper::getValue($statuses, $this->status_id);

    }

    public static function getStatuses()
    {
        return [
            self::STATUS_PUBLIC => 'Опубликован',
            self::STATUS_DRAFT  => 'Черновик',
        ];
    }

    /**
     * @return \Yii\db\ActiveQuery
     */
    public function getComments()
    {
        return $this->hasMany(\demi\comments\common\models\Comment::className(), ['material_id' => 'id'])
                    ->andOnCondition(['material_type' => 1])
                    ->orderBy(['created_at' => SORT_ASC]);
    }

    /**
     * @inheritdoc
     *
     * @return PostQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PostQuery(get_called_class());
    }

}
