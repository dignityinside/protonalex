<?php

namespace app\models\deals;

use app\models\Material;
use yii\base\Model;
use yii\data\ActiveDataProvider;

/**
 * DealsSearch represents the model behind the search form about `app\models\deals\Deals`.
 *
 * @author Alexander Schilling
 */
class DealsSearch extends Deals
{

    /** @var string */
    const SORT_BY_HITS = 'hits';

    /** @var string */
    const SORT_BY_COMMENTS = 'comments';

    /** @var string */
    const SORT_BY_PUBLISHED_ASC = 'old';

    /** @var string */
    const FILTER_BY_EXPIRED = 'expired';

    /** @var string */
    const FILTER_BY_EXPIRED_SOON = 'soon';

    /** @var array */
    const SORT_BY = [
        self::SORT_BY_HITS,
        self::SORT_BY_COMMENTS,
        self::SORT_BY_PUBLISHED_ASC,
        self::FILTER_BY_EXPIRED_SOON,
        self::FILTER_BY_EXPIRED
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
            [['status_id', 'created', 'hits', 'category_id'], 'integer'],
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

        $query = Deals::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => \Yii::$app->params['deals']['pageSize'],
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

        if ($this->sortBy === self::FILTER_BY_EXPIRED) {
            $query->andWhere(['<','valid_until', new \yii\db\Expression('now()')]);
        } elseif ($this->sortBy === self::FILTER_BY_EXPIRED_SOON) {
            $query->andWhere(['<>','valid_until', '']);
            $query->andWhere(['>','valid_until', new \yii\db\Expression('now()')]);
        } else {
            // Filter expired deals
            $query->andWhere(['is', 'valid_until', new \yii\db\Expression('null')]);
            $query->orWhere(['>','valid_until', new \yii\db\Expression('now()')]);
        }

        // Sort by

        if ($this->sortBy === self::SORT_BY_HITS) {
            $query->orderBy('hits DESC');
        } elseif ($this->sortBy === self::SORT_BY_COMMENTS) {
            $query->withCommentsCount()->all();
            $query->orderBy('commentsCount DESC');
        } elseif ($this->sortBy === self::SORT_BY_PUBLISHED_ASC) {
            $query->orderBy('created ASC');
        } elseif ($this->sortBy === self::FILTER_BY_EXPIRED_SOON) {
            $query->orderBy('valid_until ASC');
        } elseif ($this->sortBy === self::FILTER_BY_EXPIRED) {
            $query->orderBy('valid_until DESC');
        } else {
            $query->orderBy('created DESC');
        }

        return $dataProvider;

    }

}
