<?php

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\category\Category;
use app\assets\MarkdownEditorAsset;
use app\assets\ClipboardAsset;
use app\assets\ImgurUploaderAsset;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\deals\Deals */
/* @var $form yii\widgets\ActiveForm */

ClipboardAsset::register($this);
ImgurUploaderAsset::register($this);
MarkdownEditorAsset::register($this);

?>

<div class="deals-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->dropDownList(
            ArrayHelper::map(
                Category::getAllCategories(\app\models\Material::MATERIAL_DEALS_ID),
                'id',
                'name'
            ),
            [
                'prompt' => \Yii::t('app/deals', 'deals_form_select_category')
            ]
        ); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])
                 ->hint(\Yii::t('app/deals', 'deals_form_hint_title')) ?>

        <?= $form->field(
            $model,
            'content',
            [
                'template' => "{label}\n{error}\n{input}\n{hint}"
            ]
        )->textarea(['class' => 'markdown-editor'])->hint(\Yii::t('app/deals', 'deals_form_hint_content')) ?>

        <?= $form->field($model, 'author')->textInput(['maxlength' => true])
            ->hint(\Yii::t('app/deals', 'deals_form_hint_author')) ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true])
                 ->hint(\Yii::t('app/deals', 'deals_form_hint_field')) ?>

        <div id="imgur_add_img">
            <?= \Yii::t('app', 'imgur_add_img_text'); ?>
        </div>
        <input id="imgur_img_upload_field" type="file">
        <div id="imgur_img_list"></div>

        <?= $form->field($model, 'thumbnail')->textInput(['maxlength' => true])
                 ->hint(\Yii::t('app/deals', 'deals_form_hint_thumbnail')) ?>

        <?= $form->field($model, 'valid_until')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control']
        ])->hint(\Yii::t('app/deals', 'deals_form_hint_valid_until')) ?>

        <?= $form->field($model, 'price_before')->textInput(['maxlength' => true])
                 ->hint(\Yii::t('app/deals', 'deals_form_hint_price_before')) ?>

        <?= $form->field($model, 'price_after')->textInput(['maxlength' => true])
                 ->hint(\Yii::t('app/deals', 'deals_form_hint_price_after')) ?>

        <?= $form->field($model, 'coupon')->textInput(['maxlength' => true])
                 ->hint(\Yii::t('app/deals', 'deals_form_hint_coupon')) ?>

        <?= $form->field($model, 'allow_comments')->dropDownList([
                '1' => \Yii::t('app/comments', 'text_allow_comments_yes'),
                '0' => \Yii::t('app/comments', 'text_allow_comments_no')
            ]) ?>

        <?php if (UserPermissions::canAdminDeals()) : ?>
            <?= $form->field($model, 'status_id')->dropDownList($model->getStatuses()) ?>
            <?= $form->field($model, 'meta_keywords')->textInput(['maxlength' => true]) ?>
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
