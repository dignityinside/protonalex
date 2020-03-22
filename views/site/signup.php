<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\SignupForm */

$this->title = 'Регистрация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-signup">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
            <?= yii\authclient\widgets\AuthChoice::widget(
                [
                    'baseAuthUrl' => ['site/auth'],
                    'popupMode'   => false,
                ]
            ) ?>
        </div>
        <div class="col-sm-2">
            <h2>или</h2>
        </div>
        <div class="col-sm-5">
            <?php $form = ActiveForm::begin(['id' => 'form-signup']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <div class="captcha">
                <?= $form->field($model, 'captcha', ['enableAjaxValidation' => false])->label(false)
                     ->widget('demi\recaptcha\ReCaptcha', ['siteKey' => Yii::$app->params['reCAPTCHA.siteKey']]) ?>
            </div>
            <div class="form-group">
                <?= Html::submitButton(
                    'Зарегистироваться', ['class' => 'btn btn-primary', 'name' => 'signup-button']
                ) ?>
                <?= Html::a(
                    'Войти', ['site/login'], ['class' => 'btn btn-light']
                ) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
