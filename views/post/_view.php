<?php

use yii\helpers\Html;
use app\helpers\Text;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

?>
<div class="post-view">

    <div class="index_title">
        <h3><?= Html::a($model->title, ['post/view', 'slug' => $model->slug]); ?></h3>
    </div>

    <?= $this->render('_post_header', ['model' => $model]) ?>

    <?= Text::cut('[cut]',
        Text::cut('[premium]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'))),
        Html::a('Подробнее →', ['post/view', 'slug' => $model->slug])
    ); ?>

</div>
