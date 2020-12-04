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
        <?php if ($model->reading_time) : ?>
            <div class="content_header">
                <i class="fa fa-clock-o" aria-hidden="true"></i> Время прочтения ~<?= $model->reading_time; ?> мин.
            </div>
        <?php endif; ?>
        <?php if (!empty($model->preview_img)) : ?>
            <p><?= Html::a('<img src="/' . $model->preview_img . '" alt="' . $model->title . '" />', ['post/view', 'slug' => $model->slug]) ?></p>
        <?php endif; ?>
    </div>

    <?= Text::cut('[cut]',
        Text::cut('[premium]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'))),
        Html::a('Подробнее →', ['post/view', 'slug' => $model->slug])
    ); ?>

</div>
