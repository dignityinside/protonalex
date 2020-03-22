<?php

use app\assets\VideoAsset;
use app\components\UserPermissions;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\video\Video */

VideoAsset::register($this);

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => 'Видео', 'url' => ['/video/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => Html::encode($model->meta_description),
    ]
);

?>

<div class="watch-view">

    <h3><?= $this->title; ?></h3>

    <?php if (UserPermissions::canAdminVideo() || UserPermissions::canEditVideo($model)) : ?>
        <p><i class="fa fa-edit"></i>
            <?= Html::a('Изменить', ['/video/update', 'id' => $model->id]); ?></p>
    <?php endif; ?>

    <div>
        <?= $this->render('_video_player', ['model' => $model]); ?>
    </div>

    <div class="watch-view__button">
        <p>
            <?= Html::a('Открыть на <i class="fa fa-youtube"></i> YouTube', 'https://youtu.be/' . Html::encode($model->code), [
                'class' => 'btn btn-danger',
                'target' => 'blank'
            ]); ?>
        </p>
    </div>

    <div class="watch-view__description">
        <?= nl2br(Html::encode($model->description)); ?>
    </div>

    <?= $this->render('/partials/share'); ?>

    <div class="watch-view__footer">
        <i class="fa fa-clock-o"></i> <?= date('d.m.Y', Html::encode($model->published)); ?>
        <i class="fa fa-youtube"></i> Автор: <?= Html::encode($model->author); ?>
        <?php if (isset($model->category->name)) : ?>
            <i class="fa fa-folder"></i> <?= Html::a($model->category->name, '/video/category/' . $model->category->slug); ?>
        <?php endif; ?>
    </div>

    <?= $this->render('_comments', ['model' => $model]); ?>

</div>
