<?php

namespace app\models;

use Yii;
use yii\db\ActiveQuery;
use yii\db\ActiveRecord;
use yii\db\Expression;
use yii\helpers\Html;
use app\models\post\Post;
use Dignity\TranslitHelper;

/**
 * This is the model class for table "tags".
 *
 * @author Alexander Schilling
 *
 * @property string $id
 * @property string $name
 * @property string $user_id
 * @property string $created_at
 * @property string $updated_at
 * @property string $slug
 *
 * relations
 * @property Post[] $post
 *
 * getters
 * @property string $fName
 */
class Tag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tags';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {

        $scenarios = parent::scenarios();

        $scenarios['default'] = ['name'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // filter
            [['name'], 'filter', 'filter' => 'trim'],
            // required
            [['name'], 'required'],
            // integer
            [['user_id'], 'integer'],
            // string max
            [['name', 'slug'], 'string', 'max' => 255],
            // unique
            [['name', 'slug'], 'unique'],
            // default
            [['user_id'], 'default', 'value' => Yii::$app->has('user') ? Yii::$app->user->id : null],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id'         => 'ID',
            'name'       => 'Name',
            'user_id'    => 'User ID',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'slug'       => 'Slug',
        ];
    }

    /**
     * @return ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['id' => 'post_id'])->viaTable(Post::tableName(), ['tag_id' => 'id']);
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            [
                'class' => 'yii\behaviors\TimestampBehavior',
                'value' => new Expression('NOW()'),
                'createdAtAttribute' => 'created_at',
                'updatedAtAttribute' => 'updated_at',
            ],
        ];
    }

    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);
    }

    /**
     * @inheritdoc
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        // Do not forget delete the related data!

        return true;
    }

    /**
     * Get tag id by tag name.
     * Create new tag if not exists.
     *
     * @param string $name
     *
     * @return int|null Tag id
     */
    public static function getIdByName($name)
    {
        $name = trim($name);
        $tag_id = static::find()->select('id')->where(['name' => $name])->scalar();

        if ($tag_id !== false) {
            return $tag_id;
        }

        /** @var self $tag */
        $tag = new static();
        $tag->name = $name;
        $tag->user_id = Yii::$app->user->id;
        $tag->slug = TranslitHelper::translit($name);

        return $tag->save() ? $tag->id : null;
    }

    /**
     * Get HTML-encoded tag name
     *
     * @return string
     */
    public function getFName()
    {
        return Html::encode($this->name);
    }
}
