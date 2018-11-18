<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\models\Planet */

$currentPage = \Yii::$app->urlManager->createAbsoluteUrl(\Yii::$app->request->url);

?>

<div class="planet-view">

    <h3 id="<?= $model->id; ?>">
        <?= Html::a($model->title, $model->guid, ['target' => '_blank', 'rel' => 'nofollow']); ?>
        <span>
            <?= Html::a('#' . $model->id, $currentPage . '#' . $model->id) ?>
        </span>
    </h3>

    <?= HtmlPurifier::process($model->description); ?>

    <div class="content_footer">
        <i class="fa fa-clock-o"></i> <?= date('d.m.Y → H:i', Html::encode($model->pub_date)); ?>
        <i class="fa fa-user"></i> <?= Html::decode($model->author); ?>
    </div>

</div>
