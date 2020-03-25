<?php

use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Мои темы форума';

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="forum-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('<i class="fas fa-plus"></i> Создать новую тему', ['create'], ['class' => 'btn btn-success']); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
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
            [
                'attribute' => 'comments',
                'label' => 'Ответы',
                'value' => function ($model) {
                    return $model->commentsCount;
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
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/forum/topic/' . $model->id, ['target' => '_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
