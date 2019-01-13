<?php

use app\assets\PlanetAsset;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;

/* @var $this yii\web\View */
/* @var $model app\models\Planet */

PlanetAsset::register($this);

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => 'Планета', 'url' => ['/planet/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => $this->title,
    ]
);


?>

<div class="planet-view">

    <!--noindex-->

    <h3>
        <?= Html::a($this->title, $model->link, ['target' => '_blank', 'rel' => 'nofollow']); ?>
    </h3>

    <?= HtmlPurifier::process($model->description); ?>

    <div class="planet-view__source_link">
        <?= Html::a('Открыть полную статью на сайте источника →', $model->link, ['target' => '_blank', 'rel' => 'nofollow']) ?>
    </div>

    <!--/noindex-->

    <?= $this->render('/partials/ads'); ?>

    <?= $this->render('/partials/share'); ?>

    <div class="planet-view__footer">
        <i class="fa fa-clock-o"></i> <?= date('d.m.Y → H:i', Html::encode($model->pub_date)); ?>
        <i class="fa fa-user"></i> <?= Html::decode($model->author); ?>
    </div>

    <?= $this->render('_comments', ['model' => $model]); ?>

</div>
