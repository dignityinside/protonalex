<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\models\deals\Deals */

$expired = $model->url && $model->isExpired();
$class = ($expired) ? 'disabled' : 'btn-success';

echo Html::a(
    'К скидки <i class="fa fa-external-link"></i>',
    Html::encode($model->url),
    [
    'class' => 'btn ' . $class,
    'title' => 'Перейти на страницу со скидкой',
    'target' => '_blank',
    'rel' => 'nofollow'
    ]
);
