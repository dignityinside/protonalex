<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\category\Category */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="form-row">

        <div class="row">
            <div class="col">
                <div class="form-group col-md-5">
                    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="col">
                <div class="form-group col-md-3">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="col">
                <div class="form-group col-md-2">
                    <?= $form->field($model, 'material_id')->dropDownList(\app\models\Material::MATERIAL_MAPPING) ?>
                </div>
            </div>

            <div class="col">
                <div class="form-group col-md-2">
                    <?= $form->field($model, 'order')->textInput(['maxlength' => true]) ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-12">
                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <div class="form-row">
        <div class="form-group">
            <?= Html::submitButton(\Yii::t('app', 'button_save'), ['class' => 'btn btn-success']) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
