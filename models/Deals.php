<?php

namespace app\models;

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "deals".
 *
 * @author Alexander Schilling
 *
 * @property int $id
 * @property string $title
 * @property string $content
 * @property string $thumbnail
 * @property int $created
 * @property int $updated
 * @property string $author
 * @property string $user_id
 * @property int $status_id
 * @property int $category_id
 * @property string $hits
 * @property int $allow_comments
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $url
 * @property string $price_before
 * @property string $price_after
 * @property string $coupon
 * @property string $valid_until
 */
class Deals extends ActiveRecord
{

    /** @var int */
    const MATERIAL_ID = 4;

    /** @var int */
    const STATUS_PUBLIC = 1;

    /** @var int */
    const STATUS_HIDDEN = 0;

    /** @var array */
    const STATUS = [
        self::STATUS_PUBLIC => 'Опубликована',
        self::STATUS_HIDDEN  => 'Не опубликованна',
    ];

    /** @var string */
    const SCENARIO_CREATE = 'create';

    /** @var string */
    const SCENARIO_UPDATE = 'update';

    /** @var string */
    const SCENARIO_ADMIN = 'admin';

    /** @var string Count of all comments */
    public $commentsCount = 0;

    const USD = 'USD';
    const EUR = 'EUR';

    /**
     * Table name
     *
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'deals';
    }

    /**
     * Validation rules
     *
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'content', 'created', 'author', 'user_id', 'category_id'], 'required'],
            [['content'], 'string'],
            [['created', 'updated', 'user_id', 'status_id', 'category_id', 'hits', 'allow_comments'], 'integer'],
            [['valid_until'], 'safe'],
            [['title', 'thumbnail', 'author', 'url', 'price_before', 'price_after', 'coupon'], 'string', 'max' => 255],
            [['title'], 'unique'],
            [['title'], 'string', 'max' => 69],
            [['meta_keywords'], 'string', 'max' => 256],
            [['meta_description'], 'string', 'max' => 156],
        ];
    }

    /**
     * Scenarios
     *
     * @inheritdoc
     */
    public function scenarios()
    {

        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_CREATE] = [
            'title',
            'content',
            'thumbnail',
            'author',
            'category_id',
            'hits',
            'allow_comments',
            'url',
            'price_before',
            'price_after',
            'coupon',
            'valid_until'
        ];

        $scenarios[self::SCENARIO_UPDATE] = [
            'title',
            'content',
            'thumbnail',
            'author',
            'category_id',
            'hits',
            'allow_comments',
            'url',
            'price_before',
            'price_after',
            'coupon',
            'valid_until'
        ];

        $scenarios[self::SCENARIO_ADMIN] = [
            'title',
            'content',
            'thumbnail',
            'author',
            'status_id',
            'category_id',
            'hits',
            'allow_comments',
            'meta_keywords',
            'meta_description',
            'url',
            'price_before',
            'price_after',
            'coupon',
            'valid_until'
        ];

        return $scenarios;

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
            'content' => 'Описание',
            'thumbnail' => 'Картинка',
            'created' => 'Дата публикации',
            'updated' => 'Дата обновления',
            'author' => 'Автор/Организатор скидки',
            'user_id' => 'ID Автора',
            'status_id' => 'Статус',
            'category_id' => 'Категория',
            'hits' => 'Просмотров',
            'allow_comments' => 'Разрешить комментарии',
            'meta_keywords' => 'Meta Keywords',
            'meta_description' => 'Meta Description',
            'url' => 'Ссылка на сделку',
            'price_before' => 'Цена до скидки',
            'price_after' => 'Цена после скидки',
            'coupon' => 'Купон',
            'valid_until' => 'Сделка активна до'
        ];
    }

    /**
     * Find
     *
     * {@inheritdoc}
     *
     * @return DealsQuery the active query used by this AR class.
     */
    public static function find()
    {
        return new DealsQuery(get_called_class());
    }

    /**
     * Returns user
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Return category
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(Category::class, ['id' => 'category_id'])
            ->andOnCondition(['material_id' => Category::MATERIAL_DEALS]);
    }

    /**
     * Return status label
     *
     * @return mixed
     */
    public function getStatusLabel()
    {
        return ArrayHelper::getValue(self::STATUS, $this->status_id);
    }

    /**
     * Count hits
     */
    public function countViews()
    {

        global $_COOKIE;

        $name_cookies = \Yii::$app->name . '-views-deals-' . $this->id;
        $expire = 2592000; // days
        $slug = '/deals/' . $this->id;
        $all_slug = [];

        if (isset($_COOKIE[$name_cookies])) {
            $all_slug = explode('|', $_COOKIE[$name_cookies]);
        }

        if (in_array($slug, $all_slug)) {
            false;
        } else {

            $all_slug[] = $slug;
            $all_slug = array_unique($all_slug);
            $all_slug = implode('|', $all_slug);
            $expire = time() + $expire;

            @setcookie($name_cookies, $all_slug, $expire);

            $this->updateCounters(["hits" => 1]);

        }

    }

    /**
     * Returns discount
     *
     * @return bool|string
     */
    public function getDiscount()
    {

        try {

            $priceBefore = $this->getPrice($this->price_before);
            $priceAfter = $this->getPrice($this->price_after);

            $discount = ($priceAfter - $priceBefore) / $priceBefore * 100;

            return '(' . number_format($discount, 0) . '%)';

        } catch (\Exception $exception) {
            // do nothing
        }

        return '';

    }

    /**
     * Returns price
     *
     * @param string $price Price
     * @param bool $formatted Format price
     *
     * @return float|string
     */
    public function getPrice(string $price, bool $formatted = false)
    {

        if (empty($this->price_before) && empty($this->price_after)) {
            return '';
        }

        if ($this->price_before === $this->price_after) {
            return '';
        }

        $price = strtoupper($price);

        if (strrpos($price, self::USD)) {
            $price = $this->getPriceInRur($price, self::USD);
        } else if (strrpos($price, self::EUR)) {
            $price = $this->getPriceInRur($price, self::EUR);
        }

        $price = str_replace(' ', '', $price);
        $price = floatval($price);

        if ($price == 0) {
            return $formatted ? 'бесплатно' : $price;
        } else {
            return $formatted ? number_format($price, 0, ',', '.') . 'руб.' : $price;
        }

    }

    /**
     * Returns price in rur
     *
     * @param string $price Price
     * @param string $currency Currency
     *
     * @return float|int
     */
    public function getPriceInRur(string $price, string $currency)
    {

        $price = explode($currency, $price);

        if (isset($price[0]) && !empty($price[0])) {
            return floatval($price[0]) * \Yii::$app->params['deals']['cbr'][$currency];
        }

        return 0;

    }

    /**
     * Is deal expired?
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function isExpired(): bool
    {

        $today = new \DateTime();
        $validUntil = new \DateTime($this->valid_until);

        if ($this->valid_until === '0000-00-00 00:00:00') {
            return false;
        }

        if ($validUntil > $today) {
            return false;
        }

        return true;

    }

    /**
     * Before save deal
     *
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert): bool
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->isNewRecord) {

            if (isset(\Yii::$app->user->id)) {
                $this->user_id = \Yii::$app->user->id;
            }

            if (empty($this->created)) {
                $this->created = time();
            }

            if (empty($this->allow_comments)) {
                $this->allow_comments = self::STATUS_PUBLIC;
            }

            if (empty($this->author)) {
                $this->author = $this->user->username;
            }

            $this->hits = 0;

            if (empty($this->category_id)) {
                $this->category_id = 0;
            }

        }

        $this->updated = time();

        if (!UserPermissions::canAdminDeals()) {
            $this->status_id = \Yii::$app->params['deals']['preModeration'] ? self::STATUS_HIDDEN : self::STATUS_PUBLIC;
        }

        return true;

    }
}
