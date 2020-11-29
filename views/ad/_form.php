<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\ad\Ad */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-6">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-6">
                <?= $form->field($model, 'url')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-6">
                <?= $form->field($model, 'description')->textarea(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-6">
                <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
            </div>
        </div>
    </div>

    <div class="form-row">

        <div class="row">
            <div class="col">
                <div class="form-group col-md-4">
                    <?= $form->field($model, 'code')->textarea() ?>
                </div>
            </div>

            <div class="form-group col-md-4">
                <?= $form->field($model, 'banner_img')->textInput() ?>
            </div>

            <div class="col">
                <div class="form-group col-md-4">
                    <?= $form->field($model, 'banner_img_file')->fileInput(); ?>
                </div>
            </div>
        </div>

    </div>

    <div class="row">

        <div class="col">
            <div class="form-group col-md-3">
                <?= $form->field($model, 'status')->dropDownList($model->getStatuses()) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-3">
                <?= $form->field($model, 'paid_until')->textInput() ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'slot')->dropDownList([
                    $model::SLOT_POST_BOTTOM => \Yii::t('app/ad', 'post_bottom'),
                    $model::SLOT_SIDEBAR => \Yii::t('app/ad', 'sidebar'),
                ]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'target_blank')->dropDownList([
                    '1' => \Yii::t('app', 'yes'),
                    '0' => \Yii::t('app', 'no')
                ]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'rel_nofollow')->dropDownList([
                    '1' => \Yii::t('app', 'yes'),
                    '0' => \Yii::t('app', 'no')
                ]) ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-12">
                <?= $form->field($model, 'notice')->textarea(['maxlength' => true]) ?>
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
