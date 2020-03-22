<?php

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\category\Category;
use app\assets\MarkdownEditorAsset;

/* @var $this yii\web\View */
/* @var $model app\models\forum\Forum */
/* @var $form yii\widgets\ActiveForm */
/** @var int $categoryId */

MarkdownEditorAsset::register($this);

$categoryId = !empty($categoryId) ? $categoryId : 0;

?>

<div class="forum-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->dropDownList(
                ArrayHelper::map(Category::getAllCategories(\app\models\Material::MATERIAL_FORUM_ID), 'id', 'name'),
                ['prompt' => 'Выберите раздел форума', 'options'=>[(string)$categoryId=>['Selected'=>true]]]
        ); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

        <?= $form->field(
            $model, 'content', [
                'template' => "{label}\n{error}\n{input}\n{hint}"
            ]
        )->textarea(['class' => 'markdown-editor']) ?>

        <?= $form->field($model, 'allow_comments')->dropDownList(['1' => 'Да', '0' => 'Нет']) ?>

        <?php if (UserPermissions::canAdminForum()): ?>
            <?= $form->field($model, 'status_id')->dropDownList($model->getStatuses()) ?>
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
