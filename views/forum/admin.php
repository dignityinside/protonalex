<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Форум (админ)';

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="forum-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            [
                'attribute' => 'user_id',
                'label'     => 'Автор',
                'value'     => function ($model) {
                    return $model->user->username ?? 'Аноним';
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
                'attribute' => 'status_id',
                'label'     => 'Статус',
                'value'     => function ($model) {
                    return $model->getStatusLabel();
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
                'label' => 'Ответы',
                'value' => function ($model) {
                    return $model->commentsCount;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', '/forum/topic/' . $model->id, ['target' => '_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
