<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\VideoAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var string $categoryName */

VideoAsset::register($this);

$categoryName = Html::encode($categoryName);

$this->title = sprintf('Видео из категории: %s', $categoryName);

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

$this->params['breadcrumbs'][] = ['label' => 'Видео', 'url' => ['index']];

$this->params['breadcrumbs'][] = $categoryName;

?>
<div class="video-index">

    <h1><i class="fa fa-folder"></i>  <?= $categoryName; ?></h1>

    <div class="video-index-list">
        <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText' => 'Видео не найдены.',
                'itemView' => '_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
