<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сделки';

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="deals-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'id',
            'title',
            'author',
            [
                'attribute' => 'status_id',
                'label'     => 'Статус',
                'value'     => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            [
                'attribute' => 'created',
                'label' => 'Дата публикации',
                'value' => function ($model) {
                    return date('d.m.Y H:i', Html::encode($model->created));
                }
            ],
            'hits',
            [
                'attribute' => 'user_id',
                'label'     => 'Добавил',
                'value'     => function ($model) {
                    return $model->user->username ?? 'Аноним';
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/deals/view/' . $model->id, ['target' => '_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
