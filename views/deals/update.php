<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\deals */

$this->title = 'Обновить сделку';

$this->params['breadcrumbs'][] = ['label' => 'Мои скидки', 'url' => ['my']];
$this->params['breadcrumbs'][] = 'Обновить скидку';

?>

<div class="post-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
