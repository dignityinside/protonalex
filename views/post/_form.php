<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'preview')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'status_id')->dropDownList(['0' => 'Черновик', '1' => 'Опубликовать']) ?>

    <?= $form->field($model, 'tags')->textInput() ?>

    <?= $form->field($model, 'allow_comments')->dropDownList(['0' => 'Нет', '1' => 'Да']) ?>

    <?php if (\app\components\UserPermissions::canAdminPost()): ?>
        <?= $form->field($model, 'ontop')->dropDownList(['0' => 'Нет', '1' => 'Да']) ?>
        <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
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
