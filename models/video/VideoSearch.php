<?php

namespace app\models\video;

use app\models\Material;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * VideoSearch represents the model behind the search form about `app\models\video\Video`.
 *
 * @author Alexander Schilling
 */
class VideoSearch extends Video
{

    /** @var string */
    const SORT_BY_HITS = 'hits';

    /** @var string */
    const SORT_BY_COMMENTS = 'comments';

    /** @var string */
    const SORT_BY_PUBLISHED_ASC = 'old';

    /** @var array */
    const SORT_BY = [
        self::SORT_BY_HITS,
        self::SORT_BY_COMMENTS,
        self::SORT_BY_PUBLISHED_ASC
    ];

    /** @var string */
    public $sortBy;

    /** @var int */
    public $categoryId;

    /** @var int|null */
    public $userId;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['status_id', 'published', 'hits', 'category_id'], 'integer'],
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

        $query = Video::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => \Yii::$app->params['video']['pageSize'],
                ],
            ]
        );

        $this->load($params);

        if (!$this->validate()) {
            return $dataProvider;
        }

        // Filter by status

        $query->andFilterWhere(['status_id' => Material::STATUS_PUBLIC]);

        // Filter by category

        if ($this->categoryId) {
            $query->andWhere(['category_id' => $this->categoryId]);
        }

        // Filter by user

        if ($this->userId) {
            $query->andWhere(['user_id' => $this->userId]);
        }

        // Sort by

        if ($this->sortBy === self::SORT_BY_HITS) {
            $query->orderBy('hits DESC');
        } elseif ($this->sortBy === self::SORT_BY_COMMENTS) {
            $query->withCommentsCount()->all();
            $query->orderBy('commentsCount DESC');
        } elseif ($this->sortBy === self::SORT_BY_PUBLISHED_ASC) {
            $query->orderBy('published ASC');
        } else {
            $query->orderBy('published DESC');
        }

        return $dataProvider;

    }

}
