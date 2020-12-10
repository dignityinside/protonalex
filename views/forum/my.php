<?php

use app\assets\ForumAsset;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/forum', 'page_forum_my_title');

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

ForumAsset::register($this);

?>
<div class="forum-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a('<i class="fas fa-plus"></i> ' . \Yii::t('app/forum', 'forum_button_new_topics'),
            ['create'], ['class' => 'btn btn-success']); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            [
                'attribute' => 'status_id',
                'label'     => \Yii::t('app', 'columns_label_status'),
                'value'     => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => \Yii::t('app', 'columns_label_created'),
                'value' => function ($model) {
                    return $model->created_at;
                }
            ],
            [
                'attribute' => 'comments',
                'label' => \Yii::t('app', 'columns_label_comments'),
                'value' => function ($model) {
                    return $model->commentsCount;
                }
            ],
            [
                'attribute' => 'hits',
                'label' => \Yii::t('app', 'columns_label_hits'),
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