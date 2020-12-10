<?php

namespace app\models\forum;

use app\models\Material;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use yii\data\Sort;

/**
 * ForumSearch represents the model behind the search form about `app\models\forum\Forum`.
 *
 * @author Alexander Schilling
 */
class ForumSearch extends Forum
{

    /** @var string */
    public const SORT_BY_HITS = 'hits';

    /** @var string */
    public const SORT_BY_COMMENTS = 'comments';

    /** @var string */
    public const SORT_BY_PUBLISHED_ASC = 'old';

    public const SORT_BY_UNANSWERED = 'unanswered';

    /** @var array */
    public const SORT_BY = [
        self::SORT_BY_HITS,
        self::SORT_BY_COMMENTS,
        self::SORT_BY_PUBLISHED_ASC,
        self::SORT_BY_UNANSWERED
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
            [['status_id', 'created_at', 'hits', 'category_id'], 'integer'],
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

        $query = Forum::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => \Yii::$app->params['forum']['pageSize'],
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

        $query->withCommentsCount()->all();

        $query->addOrderBy('pinned DESC');

        if ($this->sortBy === self::SORT_BY_HITS) {
            $query->addOrderBy('hits DESC');
        } elseif ($this->sortBy === self::SORT_BY_COMMENTS) {
            $query->addOrderBy('commentsCount DESC');
        } elseif ($this->sortBy === self::SORT_BY_PUBLISHED_ASC) {
            $query->addOrderBy('created_at ASC');
        } elseif ($this->sortBy === self::SORT_BY_UNANSWERED) {
            $query->addOrderBy('commentsCount ASC');
        } else {
            $query->addOrderBy('created_at DESC');
        }

        return $dataProvider;
    }
}