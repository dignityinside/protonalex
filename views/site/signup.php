<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = \Yii::t('app', 'signup_title');
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <?= $form->field($model, 'payment_type')->dropDownList(\app\models\User::getPaymentTypes()) ?>
            <?= $form->field($model, 'payment_tariff')->dropDownList(\app\models\User::getTariff()) ?>
            <div class="captcha">
                <?= $form->field($model, 'captcha', ['enableAjaxValidation' => false])->label(false)
                     ->widget('demi\recaptcha\ReCaptcha', ['siteKey' => Yii::$app->params['reCAPTCHA.siteKey']]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(
                    \Yii::t('app', 'button_register'),
                    ['class' => 'btn btn-primary', 'name' => 'signup-button']
                ) ?>
                <?= Html::a(
                    \Yii::t('app', 'button_login'),
                    ['site/login'],
                    ['class' => 'btn btn-light']
                ) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
