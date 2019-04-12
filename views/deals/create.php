<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Deals */

$this->title = 'Добавить сделку';

$this->params['breadcrumbs'][] = ['label' => 'Мои сделки', 'url' => ['my']];
$this->params['breadcrumbs'][] = Html::encode($this->title);

?>
<div class="deals-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info">
        <p>Все сделки проходят премодерацию!</p>
        <p>- Запрещается публиковать сделки, которые уже есть на нашаем сайте (повтор)<br>
        - Запрещается публиковать сделки только ради реф. ссылки<br>
        - Запрещается публиковать сделки без выгоды для пользователей нашего сообщества (без скидки, промокода...)<br>
        - Запрещается копировать маркетинговые фразы и текст с других сайтов<br>
        </p>
    </div>

    <?= $this->render('_form', ['model' => $model,]) ?>

</div>
