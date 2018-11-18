<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\models\Planet */

?>

<div class="planet-view">

    <h3>
        <?= Html::a($model->title, $model->guid, ['target' => '_blank', 'rel' => 'nofollow']); ?>
    </h3>

    <?= HtmlPurifier::process($model->description); ?>

    <div class="planet-view__footer">
        <i class="fa fa-clock-o"></i> <?= date('d.m.Y → H:i', Html::encode($model->pub_date)); ?>
        <i class="fa fa-user"></i> <?= Html::decode($model->author); ?>
    </div>

</div>
