<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\models\video\Video */

?>

<div class="video-view">

    <div>
        <?= Html::a(Html::img('https://img.youtube.com/vi/' . Html::encode($model->code) . '/0.jpg', [
                'alt' => Html::encode($model->title),
                'title' => Html::encode($model->title),
            ]), '/video/watch/' . Html::encode($model->id)); ?>
    </div>

    <div class="video-view-title">
        <?= Html::a($model->title, '/video/watch/' . $model->id); ?>
    </div>

    <div class="video-view__footer">
        <i class="fa fa-clock-o"></i> <?= date('d.m.Y', Html::encode($model->published)); ?>
        <i class="fa fa-youtube"></i> <?= Html::encode($model->author); ?>
        <i class="fa fa-eye"></i> <?= Html::encode($model->hits); ?>
        <?php if ($model->commentsCount > 0): ?>
            <i class="fa fa-comments"></i> <?= Html::encode($model->commentsCount); ?>
        <?php endif; ?>
    </div>

</div>
