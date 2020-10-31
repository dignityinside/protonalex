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

$this->title = \Yii::t('app/deals', 'deals_page_title_{name}', [
    'name' => $categoryName,
]);;

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/deals', 'deals_breadcrumbs_label_index'), 'url' => ['index']];

$this->params['breadcrumbs'][] = $categoryName;

?>
<div class="deals-index">

    <div class="deals-header text-center">
        <h1>
            <i class="fa fa-folder"></i>
            <?= \Yii::t('app/deals', 'deals_category_header_title'); ?> - <?= $categoryName; ?>
        </h1>
    </div>

    <div class="deals-index-list">
        <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText' => \Yii::t('app/deals', 'deals_index_list_empty_text'),
                'itemView' => '_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
