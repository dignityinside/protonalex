<?php

use app\components\UserPermissions;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\ActiveForm;
use yii\web\JsExpression;
use kartik\select2\Select2;
use app\assets\MarkdownEditorAsset;
use app\assets\ClipboardAsset;
use app\assets\ImgurUploaderAsset;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */
/* @var $form yii\widgets\ActiveForm */

MarkdownEditorAsset::register($this);
ClipboardAsset::register($this);
ImgurUploaderAsset::register($this);

if (!is_array($model->form_tags) && !$model->isNewRecord) {
    $model->form_tags = ArrayHelper::map($model->tags, 'name', 'name');
} else {
    $model->form_tags = [];
}

?>

<div class="post-form">

    <?php $form = ActiveForm::begin(['id' => 'form-post']); ?>

    <div class="form-row">

        <div class="row">
            <div class="col">
                <div class="form-group col-md-8">
                    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

            <div class="col">
                <div class="form-group col-md-4">
                    <?= $form->field($model, 'slug')->textInput(['maxlength' => true]) ?>
                </div>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(\app\models\category\Category::getAllCategories(\app\models\Material::MATERIAL_POST_ID), 'id', 'name'), ['prompt' => 'Выберите категорию']); ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                    <?= $form->field($model, 'form_tags')->widget(
                        Select2::class,
                        [
                            'options'       => [
                                'placeholder' => \Yii::t('app/blog', 'find_tags'),
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
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-2">
                <?= $form->field($model, 'premium')->dropDownList([
                    '0' => \Yii::t('app', 'no'),
                    '1' => \Yii::t('app', 'yes')
                ]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'meta_description')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

    </div>

    <div class="row">
        <div class="col">
            <div class="col-md-12">
                <?= $form->field($model, 'preview_img_file')->fileInput(); ?>
            </div>
        </div>
    </div>

    <div class="row">

        <div class="col">

            <div class="col-md-12">
                <?= $form->field(
                    $model,
                    'content',
                    [
                        'template' => "{label}\n{error}\n{input}\n{hint}"
                    ]
                )->textarea(['class' => 'markdown-editor']) ?>

                <div id="imgur_add_img">
                    <?= \Yii::t('app', 'imgur_add_img_text') ?>
                </div>
                <input id="imgur_img_upload_field" type="file">
                <div id="imgur_img_list"></div>
            </div>

        </div>

    </div>

    <div class="row">

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'status_id')->dropDownList($model->getStatuses()) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'allow_comments')->dropDownList([
                    '1' => \Yii::t('app', 'yes'),
                    '0' => \Yii::t('app', 'no')
                ]) ?>
            </div>
        </div>

        <div class="col">
            <div class="form-group col-md-4">
                <?= $form->field($model, 'ontop')->dropDownList([
                    '1' => \Yii::t('app', 'yes'),
                    '0' => \Yii::t('app', 'no')
                ]) ?>
            </div>
        </div>

    </div>

    <div class="form-row">

        <div class="col">
            <div class="form-group">
                <?= Html::submitButton(
                    \Yii::t('app', 'button_save'),
                    ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']
                ) ?>
            </div>

        </div>

    </div>

    <?php ActiveForm::end(); ?>
</div>
