<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{

    public $name;
    public $email;
    public $subject;
    public $body;
    public $captcha;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'subject', 'body'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['captcha', 'required'],
            [
                ['captcha'], 'demi\recaptcha\ReCaptchaValidator',
                'secretKey' => Yii::$app->params['reCAPTCHA.secretKey'],
                'when'      => function ($model) {
                    /** @var $model self */
                    return !$model->hasErrors() && Yii::$app->user->isGuest;
                }
            ]
        ];
    }

    /**
     * @return array customized attribute labels
     */
    public function attributeLabels()
    {
        return [
            'name'    => 'Имя',
            'email'   => 'E-Mail',
            'subject' => 'Тема',
            'body'    => 'Сообщение',
            'captcha' => 'Капча'
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model
     *
     * @return bool whether the model passes validation
     */
    public function contact()
    {

        if ($this->validate()) {
            $body = "$this->name ($this->email) написал:\n";
            $body .= $this->body;

            Yii::$app->mailer->compose()
                             ->setTo(\Yii::$app->params['adminEmail'])
                             ->setFrom([\Yii::$app->params['noreplyEmail'] => \Yii::$app->name])
                             ->setSubject($this->subject)
                             ->setTextBody($body)
                             ->send();

            return true;
        }

        return false;
    }
}
