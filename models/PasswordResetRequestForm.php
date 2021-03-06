<?php

namespace app\models;

use yii\base\Model;

/**
 * Password reset request form
 */
class PasswordResetRequestForm extends Model
{

    public $email;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            ['email', 'filter', 'filter' => 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            [
                'email', 'exist',
                'targetClass' => '\app\models\User',
                'filter'      => ['status' => User::STATUS_WAIT],
                'message'     => 'Пользователя с таким E-Mail адресом не существует.'
            ],
        ];
    }

    /**
     * Sends an email with a link, for resetting the password.
     *
     * @return boolean whether the email was send
     */
    public function sendEmail()
    {
        /* @var $user User */
        $user = User::findOne(
            [
                'status' => User::STATUS_WAIT,
                'email'  => $this->email,
            ]
        );

        if ($user) {
            if (!User::isPasswordResetTokenValid($user->password_reset_token)) {
                $user->generatePasswordResetToken();
            }

            if ($user->save()) {
                return \Yii::$app->mailer->compose('passwordResetToken', ['user' => $user])
                                         ->setFrom([\Yii::$app->params['noreplyEmail'] => \Yii::$app->name])
                                         ->setTo($this->email)
                                         ->setSubject('Сбросить пароль ' . \Yii::$app->name)
                                         ->send();
            }
        }

        return false;
    }
}
