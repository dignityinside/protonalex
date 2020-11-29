<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\category\CategorySearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="category-search">

    <?php $form = ActiveForm::begin([
        'action' => ['admin'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'title') ?>

    <div class="form-group">
        <?= Html::submitButton(\Yii::t('app', 'button_search'), ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton(\Yii::t('app', 'button_clear'), ['class' => 'btn btn-default']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
