<?php

use app\components\UserPermissions;
use app\helpers\Text;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\Post */

$this->title = $model->title;

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $model->meta_description,
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => $model->meta_keywords,
    ]
);

?>
<div class="post-view">

    <h3><?= $this->title; ?></h3>

    <?php if (UserPermissions::canAdminPost()) : ?>
        <p><i class="fa fa-edit"></i>
            <?= Html::a('Изменить', ['post/update', 'id' => $model->id]); ?></p>
    <?php endif; ?>

    <?= Text::hidecut(HtmlPurifier::process(Markdown::process($model->content, 'gfm'))); ?>

    <?= $this->render('_share'); ?>

    <?= $this->render(
        '_post_footer', [
            'model' => $model
        ]
    ); ?>

    <?= $this->render('_comments', ['model' => $model]); ?>

</div>
