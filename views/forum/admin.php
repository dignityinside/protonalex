<?php

use app\assets\ForumAsset;
use yii\helpers\Html;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/forum', 'page_forum_admin_title');

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

ForumAsset::register($this);

?>
<div class="forum-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            [
                'attribute' => 'user_id',
                'label'     => \Yii::t('app', 'author'),
                'value'     => function ($model) {
                    return $model->user->username ?? \Yii::t('app', 'user_anonym');
                }
            ],
            [
                'attribute' => 'created_at',
                'label' => \Yii::t('app', 'columns_label_created'),
                'value' => function ($model) {
                    return Yii::$app->formatter->asRelativeTime($model->created_at);
                }
            ],
            [
                'attribute' => 'status_id',
                'label'     => \Yii::t('app', 'columns_label_status'),
                'value'     => function ($model) {
                    return $model->getStatusLabel();
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
                'attribute' => \Yii::t('app', 'columns_label_comments'),
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