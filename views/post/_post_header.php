<?php

use yii\helpers\Html;

/* @var $model app\models\post\Post */

?>

<div class="content_header">

    <i class="fa fa-clock-o"></i> <?= date('d.m.Y', Html::encode($model->datecreate)); ?>

    <i class="fa fa-eye"></i> <?= Html::encode($model->hits); ?>

    <?php if ($model->allow_comments && $model->commentsCount > 1) : ?>
        <i class="fa fa-comments"></i> <?= Html::encode($model->commentsCount); ?>
    <?php endif; ?>

</div>