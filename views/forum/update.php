<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forum */

$this->title = 'Обновить тему';

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'Мои темы форума', 'url' => ['my']];
$this->params['breadcrumbs'][] = 'Обновить тему';

?>

<div class="forum-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
