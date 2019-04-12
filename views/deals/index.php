<?php

use yii\helpers\Html;
use \yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\DealsAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сделки';

DealsAsset::register($this);

?>

<div class="deals-index">
    <h1>Сделки</h1>
    <ul class="deals-index-filter">
        <li><?= Html::a('<i class="fa fa-clock"></i>Новые', '/deals') ?></li>
        <li><?= Html::a('<i class="fa fa-eye"></i>Популярные', '/deals/hits') ?></li>
        <li><?= Html::a('<i class="fa fa-comments"></i>Обсуждаемые', '/deals/comments') ?></li>
        <li><?= Html::a('<i class="far fa-clock"></i>Старые', '/deals/old') ?></li>
    </ul>
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
