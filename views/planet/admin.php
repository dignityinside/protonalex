<?php

use app\assets\PlanetAsset;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

PlanetAsset::register($this);

$this->title = 'Планета';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="planet-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'author',
            [
                'attribute' => 'pub_date',
                'label' => 'Дата публикации',
                'value' => function ($model) {
                    return date('d.m.Y H:i', Html::decode($model->pub_date));
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $model->guid, ['target' => '_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
