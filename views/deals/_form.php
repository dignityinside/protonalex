<?php

use app\components\UserPermissions;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\models\Category;
use app\assets\MarkdownEditorAsset;
use app\assets\ClipboardAsset;
use app\assets\ImgurUploaderAsset;
use yii\jui\DatePicker;

/* @var $this yii\web\View */
/* @var $model app\models\Deals */
/* @var $form yii\widgets\ActiveForm */

ClipboardAsset::register($this);
ImgurUploaderAsset::register($this);
MarkdownEditorAsset::register($this);

?>

<div class="deals-form">

    <?php $form = ActiveForm::begin(); ?>

        <?= $form->field($model, 'category_id')->dropDownList(ArrayHelper::map(Category::getAllDealsCategories(), 'id', 'name'), ['prompt' => 'Выберите категорию']); ?>

        <?= $form->field($model, 'title')->textInput(['maxlength' => true])->hint('Короткий и содержательный заголовок.') ?>

        <?= $form->field(
            $model, 'content', [
                'template' => "{label}\n{error}\n{input}\n{hint}"
            ]
        )->textarea(['class' => 'markdown-editor'])->hint('Здесь вы можете описать свою сделку своими словами.') ?>

        <?= $form->field($model, 'author')->textInput(['maxlength' => true])->hint('Например: phpland') ?>

        <?= $form->field($model, 'url')->textInput(['maxlength' => true])->hint('Добавьте сюда ссылку на сайт, где можно найти сделку и получить дополнительную информацию.') ?>

        <div id="imgur_add_img">
            Нажмите здесь или перетащите файл, что бы загрузить картинку.
        </div>
        <input id="imgur_img_upload_field" type="file">
        <div id="imgur_img_list"></div>

        <?= $form->field($model, 'thumbnail')->textInput(['maxlength' => true])->hint('Добавьте сюда ссылку на картинку') ?>

        <?= $form->field($model, 'valid_until')->widget(DatePicker::class, [
            'language' => 'ru',
            'dateFormat' => 'yyyy-MM-dd',
            'options' => ['class' => 'form-control']
        ])->hint('Если сделка заканчивается в определенный день, пожалуйста, введите эту дату.') ?>

        <?= $form->field($model, 'price_before')->textInput(['maxlength' => true])->hint('Пожалуйста, введите цену до скидки в рублях (по умолчанию), евро (eur) или долларах (usd).') ?>

        <?= $form->field($model, 'price_after')->textInput(['maxlength' => true])->hint('Пожалуйста, введите цену после скидки в рублях, euro или usd') ?>

        <?= $form->field($model, 'coupon')->textInput(['maxlength' => true])->hint('Если у вас есть купон, пожалуйста, введите здесь.') ?>

        <?= $form->field($model, 'allow_comments')->dropDownList(['1' => 'Да', '0' => 'Нет']) ?>

        <?php if (UserPermissions::canAdminDeals()): ?>
            <?= $form->field($model, 'status_id')->dropDownList($model::STATUS) ?>
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
