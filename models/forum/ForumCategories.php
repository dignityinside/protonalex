<?php

namespace app\models\forum;

use app\models\Material;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use app\models\category\Category;

/**
 * ForumCategories represents the model behind the search form about `app\models\forum\Forum`.
 *
 * @author Alexander Schilling
 */
class ForumCategories extends Forum
{

    /** @var int */
    public $categoryId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['category_id'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search()
    {

        $query = Category::find();

        $dataProvider = new ActiveDataProvider(['query' => $query]);

        if (!$this->validate()) {
            return $dataProvider;
        }

        $query->andWhere(['material_id' => Material::MATERIAL_FORUM_ID]);

        $query->orderBy('order');

        return $dataProvider;
    }
}
