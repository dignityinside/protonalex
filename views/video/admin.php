<?php

use app\assets\VideoAsset;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

VideoAsset::register($this);

$this->title = 'Видео';

$this->params['breadcrumbs'][] = $this->title;


?>
<div class="video-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить видео', ['create'], ['class' => 'btn btn-success']); ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
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
                'attribute' => 'published',
                'label' => 'Дата публикации',
                'value' => function ($model) {
                    return date('d.m.Y H:i', Html::encode($model->published));
                }
            ],
            [
                'attribute' => 'hits',
                'label' => 'Просмотров',
                'value' => function ($model) {
                    return $model->hits;
                }
            ],
            [
                'attribute' => 'comments',
                'label' => 'Комментарий',
                'value' => function ($model) {
                    return $model->commentsCount;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/video/watch/' . $model->id, ['target' => '_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
