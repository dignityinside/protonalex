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

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description', ['template' => "{label}\n{error}\n{input}\n{hint}"])->textarea() ?>

    <?= $form->field($model, 'platform')->dropDownList($model::PLATFORM); ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => true])
             ->hint('Например: LaWxLvDgTM4 вместо https://youtu.be/LaWxLvDgTM4') ?>

    <?= $form->field($model, 'playlist')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'author')->textInput(['maxlength' => true])->hint('Например: rooland') ?>

    <?= $form->field($model, 'channel_url')->textInput(['maxlength' => true]) ?>

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

    <?= $form->field($model, 'language')->dropDownList($model::LANGUAGE) ?>

    <?= $form->field($model, 'allow_comments')->dropDownList(['1' => 'Да', '0' => 'Нет']) ?>

    <?php if (UserPermissions::canAdminVideo()): ?>
        <?= $form->field($model, 'status_id')->dropDownList($model->getStatuses()) ?>
        <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? 'Сохранить' : 'Обновить',
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
