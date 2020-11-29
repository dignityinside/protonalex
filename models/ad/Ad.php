<?php

namespace app\models\ad;

use app\models\Material;
use Yii;
use yii\db\Expression;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;
use yii\behaviors\SluggableBehavior;

/**
 * This is the model class for table "ad".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $url
 * @property string|null $banner_img
 * @property string|null $code
 * @property int $slot
 * @property int $target_blank
 * @property string $status
 * @property int|null $hits
 * @property int|null $clicks
 * @property string|null $notice
 * @property string $created_at
 * @property string $updated_at
 * @property string $paid_until
 * @property int|null $rel_nofollow
 * @property string $slug
 * @property int|null $views
 * @property string $description
 */
class Ad extends Material
{

    public const STATUS_DRAFT = 'draft';
    public const STATUS_PUBLIC = 'public';
    public const STATUS_ARCHIVED = 'archived';

    public const SLOT_POST_BOTTOM = 1;
    public const SLOT_SIDEBAR = 2;

    /** @var UploadedFile */
    public $banner_img_file;

    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ad';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['title', 'slot', 'target_blank', 'status', 'rel_nofollow'], 'required'],
            [['slot', 'target_blank', 'hits', 'clicks', 'rel_nofollow', 'views'], 'integer'],
            [['status', 'slug', 'description'], 'string'],
            [['created_at', 'updated_at'], 'safe'],
            [['title', 'url', 'banner_img', 'code', 'notice', 'slug', 'description'], 'string', 'max' => 255],
            [['banner_img_file'], 'file', 'skipOnEmpty' => true, 'extensions' => 'png, jpg'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id'              => Yii::t('app/ad', 'ID'),
            'title'           => Yii::t('app/ad', 'title'),
            'url'             => Yii::t('app/ad', 'url'),
            'banner_img'      => Yii::t('app/ad', 'banner_img'),
            'code'            => Yii::t('app/ad', 'code'),
            'slot'            => Yii::t('app/ad', 'slot'),
            'target_blank'    => Yii::t('app/ad', 'target_blank'),
            'status'          => Yii::t('app/ad', 'status'),
            'hits'            => Yii::t('app/ad', 'hits'),
            'clicks'          => Yii::t('app/ad', 'clicks'),
            'views'           => Yii::t('app/ad', 'views'),
            'notice'          => Yii::t('app/ad', 'notice'),
            'paid_until'      => Yii::t('app/ad', 'paid_until'),
            'rel_nofollow'    => Yii::t('app/ad', 'rel_nofollow'),
            'created_at'      => Yii::t('app/ad', 'created_at'),
            'updated_at'      => Yii::t('app/ad', 'updated_at'),
            'banner_img_file' => Yii::t('app/ad', 'banner_img_file'),
            'slug'            => Yii::t('app/ad', 'slug'),
            'description'     => Yii::t('app/ad', 'description'),
        ];
    }

    public function behaviors()
    {
        return [
            [
                'class' => SluggableBehavior::class,
                'attribute' => 'title',
                'slugAttribute' => 'slug',
                'ensureUnique' => true
            ],
        ];
    }

    /**
     * Returns list of statuses
     *
     * @return array
     */
    public function getStatuses(): array
    {
        return [
            self::STATUS_PUBLIC => \Yii::t('app/ad', 'status_public'),
            self::STATUS_DRAFT  => \Yii::t('app/ad', 'status_draft'),
            self::STATUS_ARCHIVED  => \Yii::t('app/ad', 'status_archived'),
        ];
    }

    /**
     * Returns status
     *
     * @return null|string
     */
    public function getStatusLabel(): ?string
    {
        return ArrayHelper::getValue($this->getStatuses(), $this->status);
    }

    /**
     * @param bool $insert
     * @return bool
     */
    public function beforeSave($insert)
    {

        if (!parent::beforeSave($insert)) {
            return false;
        }

        if ($this->banner_img_file !== null) {
            $path = 'img/slot/' . md5($this->title) . '.' . $this->banner_img_file->getExtension();
            $this->banner_img_file->saveAs($path);
            $this->banner_img = $path;
        } elseif (empty($this->banner_img)) {
            $this->banner_img = '';
        }

        return true;
    }

    /**
     * @return bool
     */
    public function beforeDelete()
    {
        if (!parent::beforeDelete()) {
            return false;
        }

        if (file_exists($this->banner_img)) {
            unlink($this->banner_img);
        }

        return true;
    }

    /**
     * Returns all categories for one material id
     *
     * @return array
     */
    public static function getRandomAd(): array
    {
        return Ad::find()->andWhere(['status' => self::STATUS_PUBLIC])->orderBy(new Expression('rand()'))->asArray()->all();
    }
}
