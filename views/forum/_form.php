<?php

use app\assets\ForumAsset;
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
ForumAsset::register($this);

$categoryId = !empty($categoryId) ? $categoryId : 0;

?>

<div class="forum-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'category_id')->dropDownList(
        ArrayHelper::map(Category::getAllCategories(\app\models\Material::MATERIAL_FORUM_ID), 'id', 'name'),
        ['prompt' => \Yii::t('app/forum', 'forum_select_category'),
         'options' => [(string)$categoryId => ['Selected' => true]]]
    ); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field(
        $model,
        'content',
        [
            'template' => "{label}\n{error}\n{input}\n{hint}"
        ]
    )->textarea(['class' => 'markdown-editor']) ?>

    <?= $form->field($model, 'allow_comments')->dropDownList([
        '1' => \Yii::t('app/comments', 'text_allow_comments_yes'),
        '0' => \Yii::t('app/comments', 'text_allow_comments_no')
    ]) ?>

    <?php if (UserPermissions::canAdminForum()) : ?>

        <?= $form->field($model, 'pinned')->dropDownList([
            '0' => \Yii::t('app', 'no'),
            '1' => \Yii::t('app', 'yes')
        ]) ?>

        <?= $form->field($model, 'status_id')->dropDownList($model->getStatuses()) ?>
        <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
    <?php endif ?>

    <div class="form-group">
        <?= Html::submitButton(
            $model->isNewRecord ? \Yii::t('app', 'button_save') : \Yii::t('app', 'button_update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
        ) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>