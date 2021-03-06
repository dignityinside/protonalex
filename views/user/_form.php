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

    <div class="form-row">
        <div class="row">
            <div class="col">
                <div class="form-group col-md-2">
                    <?php if (UserPermissions::canAdminUsers()) : ?>
                        <?= $form->field($model, 'status')->dropDownList(\app\models\User::getStatuses()) ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group col-md-2">
                    <?php if (UserPermissions::canAdminUsers()) : ?>
                        <?= $form->field($model, 'premium')->dropDownList([0 => 'Нет', 1 => 'Да']) ?>
                    <?php endif ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group col-md-2">
                    <?= $form->field($model, 'payment_type')->dropDownList(\app\models\User::getPaymentTypes()) ?>
                </div>
            </div>
            <div class="col">
                <div class="form-group col-md-2">
                    <?= $form->field($model, 'payment_tariff')->dropDownList(\app\models\User::getTariff()) ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="col">
            <div class="form-group">
                <?= Html::submitButton(
                    $model->isNewRecord ? 'Создать' : 'Сохранить профиль',
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ) ?>
            </div>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
