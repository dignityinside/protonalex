<?php

use app\components\UserPermissions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use \app\assets\MarkdownEditorAsset;

/* @var $this yii\web\View */
/* @var $model app\models\Post */
/* @var $form yii\widgets\ActiveForm */

MarkdownEditorAsset::register($this);

if (!is_array($model->form_tags) && !$model->isNewRecord) {
    $model->form_tags = ArrayHelper::map($model->tags, 'name', 'name');
} else {
    $model->form_tags = [];
}

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>

    <?= $form->field(
        $model, 'content', [
            'template' => "{label}\n{error}\n{input}\n{hint}"
        ]
    )->textarea(['class' => 'markdown-editor']) ?>

    <?= $form->field($model, 'status_id')->dropDownList(['0' => 'Черновик', '1' => 'Опубликовать']) ?>

    <?php if (UserPermissions::canAdminPost()): ?>
        <?= $form->field($model, 'form_tags')->widget(
            Select2::classname(), [
            'options'       => [
                'placeholder' => 'Найти тэг...',
                'multiple'    => true,
            ],
            'data'          => $model->form_tags,
            'pluginOptions' => [
                'tags'               => true,
                'tokenSeparators'    => [','],
                'minimumInputLength' => 2,
                'maximumInputLength' => 20,
                'allowClear'         => true,
                'initSelection'      => new JsExpression(
                    '
                function (element, callback) {
                    var data = [];
                    $(element.val()).each(function () {
                        data.push({id: this, text: this});
                    });
                    callback(data);
                }
            '
                ),
                'ajax'               => [
                    'url'      => Url::to(['tag/search']),
                    'dataType' => 'json',
                    'data'     => new JsExpression('function(params) { return {q:params.term}; }')
                ],
            ],
        ]
        );
        ?>
    <?php endif ?>

    <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(\app\models\Category::getAllPostCategories(), 'id', 'name'), ['prompt' => 'Выберите категорию']); ?>

    <?= $form->field($model, 'allow_comments')->dropDownList(['0' => 'Нет', '1' => 'Да']) ?>

    <?php if (UserPermissions::canAdminPost()): ?>
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
