<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
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
 * @property integer $category_id
 *
 * relations
 * @property Tag[] $tags
 *
 * @author Alexander Schilling
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

    /** @var int */
    const MATERIAL_ID = 1;

    /** @var string Count of all comments */
    public $commentsCount;

    /** @var array */
    public $form_tags;

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
            [['title', 'content', 'datecreate', 'dateupdate', 'user_id', 'hits', 'ontop', 'category_id'], 'required'],
            [['content', 'allow_comments', 'slug'], 'string'],
            [['status_id', 'datecreate', 'dateupdate', 'user_id', 'hits', 'ontop', 'category_id'], 'integer'],
            [['title'], 'string', 'max' => 69],
            [['meta_keywords'], 'string', 'max' => 256],
            [['meta_description'], 'string', 'max' => 156],
            [['form_tags'], 'safe'],
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
            'allow_comments',
            'status_id',
            'slug',
            'category_id'
        ];

        $scenarios[self::SCENARIO_UPDATE] = [
            'title',
            'content',
            'allow_comments',
            'status_id',
            'slug',
            'category_id'
        ];

        $scenarios[self::SCENARIO_ADMIN] = [
            'title',
            'content',
            'allow_comments',
            'status_id',
            'ontop',
            'meta_keywords',
            'meta_description',
            'slug',
            'form_tags',
            'category_id'
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
            'user_id'          => 'ID Автора',
            'hits'             => 'Просмотров',
            'allow_comments'   => 'Разрешить комментарии',
            'ontop'            => 'На главную',
            'meta_keywords'    => 'Ключевые слова (meta-keywords)',
            'meta_description' => 'Описание страницы (meta-description)',
            'slug'             => 'Постоянная ссылка',
            'form_tags'        => 'Тэги',
            'category_id'      => 'Категория'
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

    /**
     * @param bool $insert
     * @return bool
     */
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

    /**
     * @return mixed
     */
    public function getStatusLabel()
    {

        $statuses = self::getStatuses();

        return ArrayHelper::getValue($statuses, $this->status_id);

    }

    /**
     * @return array
     */
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

    /**
     * @return ActiveQuery
     */
    public function getTags()
    {
        return $this->hasMany(Tag::className(), ['id' => 'tag_id'])
                    ->select(['id', 'name'])
                    ->viaTable(PostTag::tableName(), ['post_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::className(), ['id' => 'category_id'])
                    ->andOnCondition(['material_id' => \app\models\Category::MATERIAL_POST]);
    }

    /**
     * @param bool $insert
     * @param array $changedAttributes
     * @throws \yii\db\Exception
     */
    public function afterSave($insert, $changedAttributes)
    {
        // save tags
        if (is_array($this->form_tags)) {

            if (!$insert) {
                // Remove current tags
                PostTag::deleteAll(['post_id' => $this->id]);
            }

            if (count($this->form_tags)) {

                // form tags array
                $tag_ids = [];

                foreach ($this->form_tags as $tagName) {
                    $tag_ids[] = Tag::getIdByName($tagName);
                }

                $tag_ids = array_unique($tag_ids);

                if (($i = array_search(null, $tag_ids)) !== false) {
                    unset($tag_ids[$i]);
                }

                if (count($tag_ids)) {

                    // Insert new relations data
                    $data = [];

                    foreach ($tag_ids as $tag_id) {
                        $data[] = [$this->id, $tag_id];
                    }

                    Yii::$app->db->createCommand()->batchInsert(PostTag::tableName(),
                        ['post_id', 'tag_id'], $data)->execute();
                }
            }
        }

        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        return true;
    }

}
