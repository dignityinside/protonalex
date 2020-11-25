<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */

/* @var $model app\models\ContactForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = \Yii::t('app', 'contact_title');
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>
<div class="site-contact">
    <h1><?= Html::encode($this->title) ?></h1>

    <?php if (Yii::$app->session->hasFlash('contactFormSubmitted')) : ?>
        <div class="alert alert-success">
            <?= \Yii::t('app', 'contact_email_send') ?>
        </div>
    <?php else : ?>
        <div class="row">
            <div class="col-lg-5">
                <?php $form = ActiveForm::begin(['id' => 'contact-form']); ?>

                <?= $form->field($model, 'name')->textInput(['autofocus' => true]) ?>

                <?= $form->field($model, 'email') ?>

                <?= $form->field($model, 'subject') ?>

                <?= $form->field($model, 'body')->textarea(['rows' => 6]) ?>

                <div class="captcha">
                    <?= $form->field($model, 'captcha', ['enableAjaxValidation' => false])->label(false)
                         ->widget('demi\recaptcha\ReCaptcha', ['siteKey' => Yii::$app->params['reCAPTCHA.siteKey']]) ?>
                </div>

                <div class="form-group">
                    <?= Html::submitButton(
                        \Yii::t('app', 'contact_button_send'),
                        ['class' => 'btn btn-primary', 'name' => 'contact-button']
                    ) ?>
                </div>
                <?php ActiveForm::end(); ?>
            </div>
        </div>
    <?php endif; ?>
</div>
