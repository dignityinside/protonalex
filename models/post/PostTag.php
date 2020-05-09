<?php

namespace app\models\post;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "post_tags".
 *
 * @property string $post_id
 * @property string $tag_id
 *
 * @author Alexander Schilling
 */
class PostTag extends ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'post_tags';
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {

        $scenarios = parent::scenarios();
        $scenarios['default'] = ['post_id', 'tag_id'];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['post_id', 'tag_id'], 'required'],
            [['post_id', 'tag_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'post_id' => 'Post ID',
            'tag_id' => 'Tag ID',
        ];
    }
}
