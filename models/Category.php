<?php

namespace app\models;

use Dignity\TranslitHelper;

/**
 * This is the model class for table "category".
 *
 * @author Alexander Schilling
 *
 * @property int $id
 * @property string $name
 * @property string $slug
 * @property int $material_id
 */
class Category extends \yii\db\ActiveRecord
{

    /** @var int */
    const MATERIAL_POST = 1;

    /** @var array */
    const MATERIAL_MAPPING = [
        self::MATERIAL_POST => 'Post',
    ];

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'material_id'], 'required'],
            [['material_id'], 'integer'],
            [['name', 'slug'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'slug' => 'Ярлык',
            'material_id' => 'ID сущности',
        ];
    }

    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {

            if (empty($this->slug)) {
                $this->slug = TranslitHelper::translit($this->name);
            }

        } else {

            if (empty($this->slug)) {
                $this->slug = TranslitHelper::translit($this->name);
            }

        }

        return true;

    }

    /**
     * Returns all post categories
     *
     * @return array|\yii\db\ActiveRecord[]
     */
    public static function getAllPostCategories(): array
    {
        return Category::find()->andWhere(['material_id'=>self::MATERIAL_POST])->all();
    }
}
