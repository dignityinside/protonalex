<?php

use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\DealsAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/deals', 'page_deals_index_title');

DealsAsset::register($this);

?>

<div class="deals-index">

    <div class="post-header text-center">
        <h1><i class="fas fa-handshake"></i> <?= $this->title ?></h1>
    </div>

    <ul class="deals-index-filter">
        <li><?= Html::a('<i class="fa fa-clock"></i>' . \Yii::t('app', 'sort_new'),
                '/deals') ?></li>
        <li><?= Html::a('<i class="fa fa-eye"></i>' . \Yii::t('app', 'sort_hits'),
                '/deals/hits') ?></li>
        <li><?= Html::a('<i class="fa fa-comments"></i>' . \Yii::t('app', 'sort_comments'),
                '/deals/comments') ?></li>
        <li><?= Html::a('<i class="far fa-clock"></i>' . \Yii::t('app/deals', 'deals_index_filter_soon'),
                '/deals/soon') ?></li>
        <li><?= Html::a('<i class="fas fa-flag-checkered"></i>' . \Yii::t('app/deals', 'deals_index_filter_expired'),
                '/deals/expired') ?></li>
    </ul>
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
