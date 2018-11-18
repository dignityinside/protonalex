<?php

use \yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\PlanetAsset;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Планета';

PlanetAsset::register($this);

?>

<div class="planet-index">
    <h1><i class="fa fa-globe"></i> Планета</h1>
    <p>Планета собирает интересные статьи из различных источников и объединяет их в одну ленту.</p>
    <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText' => 'Записи не найдены.',
                'itemView' => '_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
    <?php Pjax::end(); ?>
</div>
