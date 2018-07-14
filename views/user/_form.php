<?php

use app\components\UserPermissions;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="user-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'aads_com_id')->textInput(['maxlength' => true])->hint('Укажите здесь ваш <a href="http://a-ads.com?partner=' . \Yii::$app->params['aads_com_id'] . '" target="_blank"> a-ads.com id</a>, если хотите показывать рекламу в своих постах.') ?>

    <?= $form->field($model, 'ads_visibility')->dropDownList($model->getAdsVisibility()) ?>

    <?php if (UserPermissions::canAdminUsers()): ?>
        <?= $form->field($model, 'status')->dropDownList(\app\models\User::getStatuses()) ?>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Создать' : 'Сохранить профиль',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
