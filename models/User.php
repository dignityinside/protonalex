<?php

namespace app\models;

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
 * @property string $aads_com_id
 * @property integer $ads_visibility
 *
 * @property Auth[] $auths
 */
class User extends ActiveRecord implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 10;

    const SCENARIO_UPDATE = 'update';
    const SCENARIO_ADMIN = 'admin';

    const VISIBILITY_HIDE = 0;
    const VISIBILITY_REGISTER_USER_ONLY = 1;
    const VISIBILITY_ALL_USERS = 2;

    public $avatar_url = '';

    /** @var array */
    public $visibilityMapping = [
        self::VISIBILITY_HIDE => 'Никому',
        self::VISIBILITY_REGISTER_USER_ONLY => 'Только не зарегистированным пользователям',
        self::VISIBILITY_ALL_USERS => 'Всем пользователям'
    ];

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
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => self::STATUS_ACTIVE],
            ['status', 'in', 'range' => [self::STATUS_ACTIVE, self::STATUS_DELETED]],
            ['status', 'filter', 'filter' => 'intval'],
            [['aads_com_id', 'ads_visibility'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {

        $scenarios = parent::scenarios();

        $scenarios[self::SCENARIO_UPDATE] = [
            'aads_com_id',
            'ads_visibility'
        ];

        $scenarios[self::SCENARIO_ADMIN] = [
            'status',
            'aads_com_id',
            'ads_visibility'
        ];

        return $scenarios;

    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => self::STATUS_ACTIVE]);
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
        return static::findOne(['username' => $username, 'status' => self::STATUS_ACTIVE]);
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

        return static::findOne(
            [
                'password_reset_token' => $token,
                'status'               => self::STATUS_ACTIVE,
            ]
        );

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
        $this->password_hash = Yii::$app->security->generatePasswordHash($password);;
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

    public function attributeLabels()
    {
        return [
            'id'             => 'ID',
            'username'       => 'Имя пользователя',
            'email'          => 'E-Mail',
            'status'         => 'Статус',
            'created_at'     => 'Создан в',
            'aads_com_id'    => 'a-ads.com id',
            'ads_visibility' => 'Кому можно показывать рекламу?'
        ];
    }

    public function getStatusLabel()
    {
        $statuses = self::getStatuses();

        return ArrayHelper::getValue($statuses, $this->status);
    }

    public static function getStatuses()
    {
        return [
            self::STATUS_DELETED => 'Delete',
            self::STATUS_ACTIVE  => 'Active',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAuths()
    {
        return $this->hasMany(Auth::className(), ['user_id' => 'id']);
    }

    /**
     * @return string GitHub profile URL or null if user isn't connected with GitHub
     */
    public function getGithubProfileUrl()
    {
        return $this->github ? 'http://github.com/' . $this->github : null;
    }

    /**
     * Returns ads visibility mapping
     *
     * @return array
     */
    public function getAdsVisibility() {
        return $this->visibilityMapping;
    }

}
