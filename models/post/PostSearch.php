<?php

namespace app\models\post;

use app\models\Material;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * PostSearch represents the model behind the search form about `app\models\post\Post`.
 *
 * @author Alexander Schilling
 */
class PostSearch extends Post
{

    public const FILTER_BY_HITS = 1;
    public const FILTER_BY_COMMENTS = 2;

    /** @var int */
    public $tagId;

    /** @var int */
    public $categoryId;

    /** @var int */
    public $sortBy;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status_id', 'datecreate', 'dateupdate', 'category_id', 'user_id', 'hits', 'ontop', 'premium'], 'integer'],
            [['title', 'content', 'tags', 'allow_comments', 'meta_description'], 'safe'],
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
    public function search($params)
    {
        $query = Post::find();

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 6,
                ],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
                'status_id' => Material::STATUS_PUBLIC,
                'ontop'     => Post::SHOW_ON_TOP
            ]
        );

        $query->andFilterWhere(['like', 'title', $this->title]);

        // Filter by tag id

        if (!$this->tagId) {
            $query->withCommentsCount()->all();
            $query->with(['tags']);
        } else {
            $query->joinWith(['tags']);
            $query->andWhere(['post_tags.tag_id' => $this->tagId]);
        }

        // Filter by category

        if ($this->categoryId) {
            $query->andWhere(['category_id' => $this->categoryId]);
        }

        if ($this->sortBy === self::FILTER_BY_HITS) {
            $query->orderBy('hits DESC');
        } elseif ($this->sortBy === self::FILTER_BY_COMMENTS) {
            $query->orderBy('commentsCount DESC');
        } else {
            $query->orderBy('datecreate DESC');
        }

        return $dataProvider;
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function adminSearch($params)
    {
        $query = Post::find()->orderBy('datecreate DESC');

        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }

        // grid filtering conditions
        $query->andFilterWhere(
            [
                'id'          => $this->id,
                'status_id'   => $this->status_id,
                'user_id'     => $this->user_id,
                'ontop'       => $this->ontop,
            ]
        );

        $query->andFilterWhere(['like', 'title', $this->title]);

        $query->withCommentsCount()->all();

        return $dataProvider;
    }
}
