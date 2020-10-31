<?php

use demi\comments\frontend\widgets\Comments;
use yii\helpers\Html;
use yii\web\View;
use yii\widgets\ActiveForm;

/* @var $this View */
/* @var $widget Comments */
/* @var $model demi\comments\common\models\Comment */

?>

<hr/>

<h3 class="text-primary">
    <span class="restore-comment-form" style="border-bottom: 1px dashed #585a53; cursor: pointer;">
        <?= \Yii::t('app/comments', 'button_restore_comment_form'); ?>
    </span>
</h3>

<div class="primary-form-container">
    <div class="comment-form">
        <?php $form = ActiveForm::begin($widget->formConfig); ?>

        <?= Html::activeHiddenInput($model, 'parent_id', ['class' => 'parent_comment_id']) ?>
        <?= Html::activeHiddenInput($model, 'material_type') ?>
        <?= Html::activeHiddenInput($model, 'material_id') ?>

        <?php if (Yii::$app->user->isGuest) : ?>
            <div class="row">
                <?= $form->field($model, 'user_name', ['options' => ['class' => 'col-md-6']])
                         ->textInput(['maxlength' => true])
                         ->label(\Yii::t('app', 'username')) ?>

                <?= $form->field($model, 'user_email', ['options' => ['class' => 'col-md-6']])
                         ->input('email')
                         ->label(\Yii::t('app', 'email')); ?>
            </div>
        <?php endif ?>

        <div class="row">
            <?= $form->field($model, 'text', ['options' => ['class' => 'col-md-12']])
                     ->textarea(['rows' => 4, 'maxlength' => true])
                     ->label(\Yii::t('app/comments', 'field_label_comment')) ?>
        </div>

        <div class="row">
            <div class="col-md-6">
                <?= Html::submitButton(\Yii::t('app/comments', 'button_send_comment'),
                    ['class' => 'btn btn-primary btn-lg']) ?>
                <?php if (Yii::$app->user->isGuest) : ?>
                <?php endif ?>
            </div>
            <?php if (Yii::$app->user->isGuest) : ?>
                <div class="col-md-6">
                    <div class="pull-right">
                        <div class="captcha">
                        <?= $form->field($model, 'captcha', ['enableAjaxValidation' => false])->label(false)
                                 ->widget(
                                     'demi\recaptcha\ReCaptcha',
                                     ['siteKey' => $widget->component->reCaptchaSiteKey]
                                 ) ?>
                        </div>
                    </div>
                </div>
            <?php endif ?>
        </div>

        <?php ActiveForm::end(); ?>
    </div>
</div>