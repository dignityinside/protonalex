<?php

namespace app\models;

use DateTime;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;
use yii\helpers\ArrayHelper;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 * @property string $github
 * @property string $premium
 * @property string $payment_type
 * @property string $payment_tariff
 * @property string $premium_until
 *
 * @property Auth[] $auths
 */
class User extends ActiveRecord implements IdentityInterface
{

    public const STATUS_DELETED = 0;
    public const STATUS_WAIT = 10;
    public const STATUS_PAID = 20;

    public const PAYMENT_TYPE_PAYPAL = 1;
    public const PAYMENT_TYPE_WEBMONEY = 2;
    //public const PAYMENT_TYPE_BANK = 3;
    //public const PAYMENT_TYPE_YANDEXMONEY = 4;

    public const TARIFF_MONTH = 1;
    public const TARIFF_YEAR = 12;

    public const SCENARIO_UPDATE = 'update';
    public const SCENARIO_ADMIN = 'admin';

    public const ALLOWED_PAYMENT_TYPES = [
        self::PAYMENT_TYPE_PAYPAL,
        self::PAYMENT_TYPE_WEBMONEY,
        //self::PAYMENT_TYPE_BANK,
        // self::PAYMENT_TYPE_YANDEXMONEY,
    ];

    public const ALLOWED_PAYMENT_TARIFF = [
        self::TARIFF_MONTH,
        self::TARIFF_YEAR,
    ];


    public $avatar_url = '';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_WAIT],
            ['status', 'in', 'range' => [self:: STATUS_WAIT, self::STATUS_PAID, self::STATUS_DELETED]],
            ['payment_type', 'in', 'range' => self::ALLOWED_PAYMENT_TYPES],
            ['payment_tariff', 'in', 'range' => self::ALLOWED_PAYMENT_TARIFF],
            ['status', 'filter', 'filter' => 'intval'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        $scenarios = parent::scenarios();

        // $scenarios[self::SCENARIO_UPDATE] = [];

        $scenarios[self::SCENARIO_ADMIN] = [
            'status',
            'premium',
            'payment_tariff',
            'payment_type',
            'payment_until',
        ];

        return $scenarios;
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     *
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     *
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne(['password_reset_token' => $token]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     *
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        $parts = explode('_', $token);
        $timestamp = (int)end($parts);

        return $timestamp + $expire >= time();
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     *
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);
        ;
    }

    public function getPassword()
    {
        return $this->password_hash;
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    /**
     * @return array
     */
    public function attributeLabels(): array
    {
        return [
            'id'             => 'ID',
            'username'       => \Yii::t('app', 'username'),
            'email'          => \Yii::t('app', 'email'),
            'status'         => \Yii::t('app', 'status'),
            'created_at'     => \Yii::t('app', 'created_at'),
            'premium'        => \Yii::t('app', 'premium'),
            'payment_tariff' => \Yii::t('app', 'payment_tariff'),
            'payment_type'   => \Yii::t('app', 'payment_type'),
            'premium_until'  => \Yii::t('app', 'premium_until'),
        ];
    }

    /**
     * @param bool $insert
     *
     * @return bool
     */
    public function beforeSave($insert)
    {
        if (!parent::beforeSave($insert)) {
            return false;
        }

        if (!$this->isNewRecord) {
            if ($this->status === self::STATUS_PAID) {

                $this->premium = 1;

                if ((int) $this->payment_tariff === self::TARIFF_MONTH) {
                    $this->premium_until = date('Y-m-d H:i:s', strtotime('+30 days'));
                } elseif ((int) $this->payment_tariff === self::TARIFF_YEAR) {
                    $this->premium_until = date('Y-m-d H:i:s', strtotime('+1 year'));
                } else {
                    $this->premium_until = null;
                }

            } else {
                $this->premium = 0;
                $this->premium_until = null;
            }
        }

        return true;
    }

    /**
     * Return status label
     *
     * @return mixed|null
     *
     * @throws \Exception
     */
    public function getStatusLabel()
    {
        $statuses = self::getStatuses();

        return ArrayHelper::getValue($statuses, $this->status);
    }

    /**
     * List of statuses
     *
     * @return array
     */
    public static function getStatuses()
    {
        return [
            self::STATUS_PAID    => \Yii::t('app', 'user_status_paid'),
            self::STATUS_WAIT    => \Yii::t('app', 'user_status_wait'),
            self::STATUS_DELETED => \Yii::t('app', 'user_status_deleted'),
        ];
    }

    /**
     * List of payment types
     *
     * @return array
     */
    public static function getPaymentTypes()
    {
        return [
            self::PAYMENT_TYPE_PAYPAL      => \Yii::t('app', 'payment_type_paypal'),
            self::PAYMENT_TYPE_WEBMONEY    => \Yii::t('app', 'payment_type_webmoney'),
            // self::PAYMENT_TYPE_YANDEXMONEY => \Yii::t('app', 'payment_type_yandexmoney'),
            // self::PAYMENT_TYPE_BANK        => \Yii::t('app', 'payment_type_bank'),
        ];
    }

    /**
     * List of tariffs
     *
     * @return array
     */
    public static function getTariff(): array
    {
        return [
            self::TARIFF_MONTH => \Yii::t('app', 'tariff_month'),
            self::TARIFF_YEAR  => \Yii::t('app', 'tariff_year'),
        ];
    }

    /**
     * Returns premium price by tariff
     *
     * @param int $paymentTariff
     *
     * @return string
     */
    public static function getPremiumPriceByTariff(int $paymentTariff): string
    {
        if ($paymentTariff === self::TARIFF_MONTH) {
            return Yii::$app->formatter->asCurrency(\Yii::$app->params['premium']['price']);
        }

        $yearPrice = \Yii::$app->params['premium']['price'] * (12 - \Yii::$app->params['premium']['freeMonth']);

        return Yii::$app->formatter->asCurrency($yearPrice);
    }

    /**
     * Returns payment wallet
     *
     * @param int $paymentType
     *
     * @return string
     */
    public static function getPaymentWallet(int $paymentType): string
    {
        if (isset(Yii::$app->params['premium']['paymentType'])) {

            $premiumPaymentType = Yii::$app->params['premium']['paymentType'];

            if ($paymentType === self::PAYMENT_TYPE_PAYPAL) {
                return !empty($premiumPaymentType['paypal']) ? $premiumPaymentType['paypal'] : '---';
            }

            if ($paymentType === self::PAYMENT_TYPE_WEBMONEY) {
                return !empty($premiumPaymentType['webmoney']) ? $premiumPaymentType['webmoney'] : '---';
            }

//            if ($paymentType === self::PAYMENT_TYPE_BANK) {
//                return !empty($premiumPaymentType['bank']) ? $premiumPaymentType['bank'] : '---';
//            }

//            if ($paymentType === self::PAYMENT_TYPE_YANDEXMONEY) {
//                return !empty($premiumPaymentType['yandexmoney']) ? $premiumPaymentType['yandexmoney'] : '---';
//            }
//


        }

        return '---';
    }

    /**
     * @param $premiumUntil
     *
     * @return bool
     *
     * @throws \Exception
     */
    public function isExpired($premiumUntil): bool
    {

        if ($premiumUntil === null) {
            return true;
        }

        $today = new DateTime(date("Y-m-d H:i:s"));
        $expired = new DateTime($premiumUntil);

        return $expired->getTimestamp() < $today->getTimestamp();
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::class, ['user_id' => 'id']);
    }
}
