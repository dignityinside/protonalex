<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\DealsAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var string $categoryName */

DealsAsset::register($this);

$categoryName = Html::encode($categoryName);

$this->title = sprintf('Сделки из категории: %s', $categoryName);

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => strtolower($categoryName),
    ]
);

$this->params['breadcrumbs'][] = ['label' => 'Сделки', 'url' => ['index']];

$this->params['breadcrumbs'][] = $categoryName;

?>
<div class="deals-index">

    <h1><i class="fa fa-folder"></i>  <?= $categoryName; ?></h1>

    <div class="deals-index-list">
        <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText' => 'Сделки не найдены.',
                'itemView' => '_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
