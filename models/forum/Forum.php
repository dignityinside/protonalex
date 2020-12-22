<?php

namespace app\models\forum;

use app\models\Material;
use app\components\UserPermissions;
use app\models\category\Category;
use demi\comments\common\models\Comment;
use Yii;

/**
 * This is the model class for table "forum".
 *
 * @author Alexander Schilling
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property int $created_at
 * @property int $updated_at
 * @property string $user_id
 * @property int $status_id
 * @property int $category_id
 * @property string $hits
 * @property int $allow_comments
 * @property string $meta_description
 * @property int $pinned
 * @property int $premium
 */
class Forum extends Material
{

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
            [['title', 'content', 'created_at', 'user_id', 'category_id'], 'required'],
            [['content'], 'string'],
            [['created_at', 'updated_at', 'user_id', 'status_id', 'category_id', 'hits', 'allow_comments', 'pinned', 'premium'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['title'], 'string', 'max' => 69],
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

        $scenarios[Material::SCENARIO_CREATE] = [
            'title',
            'content',
            'category_id',
            'hits',
            'allow_comments'
        ];

        $scenarios[Material::SCENARIO_UPDATE] = [
            'title',
            'content',
            'category_id',
            'hits',
            'allow_comments',
        ];

        $scenarios[Material::SCENARIO_ADMIN] = [
            'title',
            'content',
            'status_id',
            'category_id',
            'hits',
            'allow_comments',
            'meta_description',
            'pinned',
            'premium'
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
            'created_at' => 'Дата публикации',
            'updated_at' => 'Дата обновления',
            'user_id' => 'ID Автора',
            'status_id' => 'Статус',
            'category_id' => 'Раздел',
            'hits' => 'Просмотры',
            'allow_comments' => 'Разрешить отвечать на тему',
            'meta_description' => 'Meta Description',
            'pinned' => 'Прекрепить тему',
            'premium' => 'Премиум',
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
     * Return category
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])
            ->andOnCondition(['material_id' => Material::MATERIAL_FORUM_ID]);
    }

    /**
     * @return string
     */
    public function getFormattedCreatedAt(): string
    {
        $formatter = Yii::$app->formatter;

        return $formatter->asRelativeTime($this->created_at) . ' (' . $formatter->asDatetime($this->created_at, 'short') . ')';
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

            if (empty($this->allow_comments)) {
                $this->allow_comments = Material::STATUS_PUBLIC;
            }

            $this->hits = 1;

            if (empty($this->category_id)) {
                $this->category_id = 0;
            }
        }

        if (empty($this->meta_description)) {
            $this->meta_description = $this->title;
        }

        if (!UserPermissions::canAdminForum()) {
            $this->status_id = \Yii::$app->params['forum']['preModeration']
                ? Material::STATUS_DRAFT : Material::STATUS_PUBLIC;
        }

        return true;
    }

    /**
     * Before delete
     *
     * @return bool
     */
    public function beforeDelete(): bool
    {
        // remove all comments for topic

        Comment::deleteAll(['material_type' => Material::MATERIAL_FORUM_ID, 'material_id' => $this->id]);

        if (!parent::beforeDelete()) {
            return false;
        }

        return true;
    }
}
