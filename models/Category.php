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
            'material_id' => 'Material ID',
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

}
