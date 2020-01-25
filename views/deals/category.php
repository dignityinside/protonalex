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

$this->title = sprintf('Скидки из категории: %s', $categoryName);

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

$this->params['breadcrumbs'][] = ['label' => 'Скидки', 'url' => ['index']];

$this->params['breadcrumbs'][] = $categoryName;

?>
<div class="deals-index">

    <div class="deals-header text-center">
        <h1><i class="fa fa-folder"></i> Скидки - <?= $categoryName; ?></h1>
    </div>

    <div class="deals-index-list">
        <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText' => 'Скидки не найдены.',
                'itemView' => '_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
