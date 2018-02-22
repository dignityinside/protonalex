<?php

use yii\helpers\Html;

/* @var $model app\models\Post */

?>

<div class="content_header">

    <i class="fa fa-clock-o"></i> <?= date('H:i → d.m.Y', $model->datecreate); ?>

    <i class="fa fa-eye"></i> <?= $model->hits; ?>

    <i class="fa fa-user"></i>

    <?php if (!empty($model->user_id)) : ?>
        <?= Html::a($model->author->username, ['user/view', 'id' => $model->user_id]); ?>
    <?php else: ?>
        <?= 'Аноним'; ?>
    <?php endif; ?>

    <i class="fa fa-comment"></i> <?= $model->commentsCount ?>

</div>