<?php

use yii\helpers\Html;
use app\widgets\Bbcode;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

?>
<div class="post-view">

    <h3><?= Html::a($model->title, ['post/view', 'id' => $model->id]); ?></h3>

    <?= $this->render('_post_header', ['model' => $model]) ?>

    <?= Bbcode::widget(['text' => $model->preview]); ?>

    <?php if ($model->content): ?>
        <p><?= Html::a('Подробнее →', ['post/view', 'id' => $model->id]); ?></p>
    <?php endif; ?>

</div>
