<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Forum */

$this->title = 'Новая тема';

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Мои темы', 'url' => ['my']];
$this->params['breadcrumbs'][] = Html::encode($this->title);

?>
<div class="forum-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model, 'categoryId' => $categoryId]) ?>
</div>
