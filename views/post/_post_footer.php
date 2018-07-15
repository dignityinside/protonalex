<?php

use yii\helpers\Html;
use app\helpers\Text;

/* @var $model app\models\Post */

?>

<div class="content_footer">

    <i class="fa fa-clock-o"></i> <?= date('H:i → d.m.Y', Html::encode($model->datecreate)); ?>

    <i class="fa fa-eye"></i> <?= Html::encode($model->hits); ?>

    <i class="fa fa-user"></i>

    <?php if (isset($model->author->username)) : ?>
        <?= Html::a($model->author->username, ['/user/view', 'id' => $model->user_id]); ?>
    <?php else: ?>
        <?= 'Аноним'; ?>
    <?php endif; ?>

    <i class="fa fa-comments"></i> <?= Html::encode($model->commentsCount); ?>

    <?php if (isset($model->category->name)) : ?>
        <i class="fa fa-folder"></i> <?= Html::a($model->category->name, '/category/' . $model->category->slug); ?>
    <?php endif; ?>

    <?php if (!empty($model->tags)): ?>
        <i class="fa fa-tags"></i> <?= Text::getTagsList($model); ?>
    <?php endif; ?>

</div>