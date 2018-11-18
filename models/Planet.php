<?php

namespace app\models;

/**
 * This is the model class for table "planet".
 *
 * @author Alexander Schilling
 *
 * @property int $id
 * @property string $title
 * @property string $description
 * @property string $guid
 * @property string $link
 * @property int $pub_date
 * @property string $author
 * @property int $status_id
 */
class Planet extends \yii\db\ActiveRecord
{

    const STATUS_PUBLIC = 1;

    const STATUS_HIDDEN = 0;

    /**
     * Table name
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'planet';
    }

    /**
     * Validation rules
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'description', 'pub_date', 'author'], 'required'],
            [['description'], 'string'],
            [['title', 'guid', 'link','author'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['status_id', 'pub_date'], 'integer'],
        ];
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
            'title' => 'Заголовок',
            'description' => 'Описание',
            'guid' => 'Ссылка на пост',
            'link' => 'Link',
            'pub_date' => 'Дата публикации',
            'author' => 'Автор',
            'status_id' => 'Статус'
        ];
    }

    /**
     * Find
     *
     * {@inheritdoc}
     *
     * @return PlanetQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new PlanetQuery(get_called_class());
    }
}
