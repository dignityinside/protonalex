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
            [['name', 'email', 'subject', 'body', 'captcha'], 'required'],
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
            'name'    => \Yii::t('app', 'contact_name'),
            'email'   => \Yii::t('app', 'contact_email'),
            'subject' => \Yii::t('app', 'contact_subject'),
            'body'    => \Yii::t('app', 'contact_body'),
            'captcha' => \Yii::t('app', 'contact_captcha')
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
            Yii::$app->mailer->compose()
                ->setTo(\Yii::$app->params['adminEmail'])
                ->setFrom([\Yii::$app->params['noreplyEmail'] => \Yii::$app->name])
                ->setSubject($this->subject)
                ->setTextBody($this->name . "\n\n" . $this->email . "\n\n". $this->body)
                ->send();

            return true;
        }

        return false;
    }
}
