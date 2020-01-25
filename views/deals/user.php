<?php

use \yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\DealsAsset;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */
/** @var string $userName */

$this->title = 'Скидки пользователя ' . $userName;

DealsAsset::register($this);

?>

<div class="deals-index">
    <h1><i class="fa fa-youtube"></i> Скидки пользователя <?= $userName ?></h1>
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
