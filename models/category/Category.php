<?php

namespace app\models\category;

use app\models\forum\Forum;
use app\models\Material;
use app\models\post\Post;
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
 * @property string $description
 * @property int $order
 * @property string $icon
 */
class Category extends Material
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
            [['material_id', 'order'], 'integer'],
            [['name', 'slug', 'description', 'icon'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'          => 'ID',
            'name'        => 'Название',
            'slug'        => 'Ярлык',
            'material_id' => 'ID сущности',
            'description' => 'Описание',
            'order'       => 'Последовательность',
            'icon'        => 'Иконка',
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
     * Returns all categories for material id
     *
     * @return array
     */
    public static function getAllCategories(int $materialId): array
    {
        return Category::find()->andWhere(['material_id' => $materialId])->all();
    }

    /**
     * Return related posts for category
     *
     * @return \yii\db\ActiveQuery
     */
    public function getPosts()
    {
        return $this->hasMany(Post::class, ['category_id' => 'id'])
            ->where([
                'ontop' => Post::SHOW_ON_TOP,
                'status_id' => Post::STATUS_PUBLIC
            ]);
    }

    /**
     * Return related forums for category
     *
     * @return \yii\db\ActiveQuery
     */
    public function getForums()
    {
        return $this->hasMany(Forum::class, ['category_id' => 'id'])->where(['status_id' => Post::STATUS_PUBLIC]);
    }

    /**
     * Returns all categories for one material id
     *
     * @return array
     */
    public static function getCategoriesList(int $materialId): array
    {
        return Category::find()->andWhere(['material_id' => $materialId])->orderBy('order')->with("posts")->asArray()->all();
    }
}
