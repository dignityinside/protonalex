<?php

namespace app\models\forum;

use app\models\Material;
use app\components\UserPermissions;
use app\models\category\Category;

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
 * @property string $meta_description
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
            [['title', 'content', 'created', 'user_id', 'category_id'], 'required'],
            [['content'], 'string'],
            [['created', 'updated', 'user_id', 'status_id', 'category_id', 'hits', 'allow_comments'], 'integer'],
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
                $this->allow_comments = Material::STATUS_PUBLIC;
            }

            $this->hits = 0;

            if (empty($this->category_id)) {
                $this->category_id = 0;
            }
        }

        $this->updated = time();

        if (!UserPermissions::canAdminForum()) {
            $this->status_id = \Yii::$app->params['forum']['preModeration']
                ? Material::STATUS_DRAFT : Material::STATUS_PUBLIC;
        }

        return true;
    }
}
