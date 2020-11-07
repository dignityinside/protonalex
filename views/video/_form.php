<?php

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\category\Category;

/* @var $this yii\web\View */
/* @var $model app\models\video\Video */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="video-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-5">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-3">
                <?= $form->field($model, 'author')->textInput(['maxlength' => true]); ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'category_id')->dropDownList(
                    ArrayHelper::map(
                        Category::getAllCategories(\app\models\Material::MATERIAL_VIDEO_ID),
                        'id',
                        'name'
                    ),
                    [
                        'prompt' => 'Выберите категорию'
                    ]
                ); ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'language')->dropDownList($model::LANGUAGE) ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-12">
                <?= $form->field($model, 'description', ['template' => "{label}\n{error}\n{input}\n{hint}"])->textarea() ?>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'code')->textInput(['maxlength' => true]); ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'channel_url')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'playlist')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'platform')->dropDownList($model::PLATFORM); ?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col">
            <div class="form-group col-md-3">
                <?= $form->field($model, 'status_id')->dropDownList($model->getStatuses()) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-3">
                <?= $form->field($model, 'allow_comments')->dropDownList(['1' => 'Да', '0' => 'Нет']) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-6">
                <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    </div>

    <div class="form-row">
        <div class="form-group">
            <?= Html::submitButton(
                $model->isNewRecord ? 'Сохранить' : 'Обновить',
                ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
