<?php

use yii\helpers\Html;
use yii\grid\GridView;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/deals', 'deals_page_admin_title');

$this->params['breadcrumbs'][] = $this->title;

?>
<div class="deals-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= Html::a(\Yii::t('app/deals', 'deals_button_add'), ['create'], ['class' => 'btn btn-success']); ?></p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'title',
            'author',
            [
                'attribute' => 'status_id',
                'label'     => \Yii::t('app', 'columns_label_status'),
                'value'     => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            [
                'attribute' => 'created',
                'label' => \Yii::t('app', 'columns_label_created'),
                'value' => function ($model) {
                    return date('d.m.Y H:i', Html::encode($model->created));
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
                'attribute' => 'comments',
                'label' => \Yii::t('app', 'columns_label_comments'),
                'value' => function ($model) {
                    return $model->commentsCount;
                }
            ],
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>',
                            '/deals/view/' . $model->id, ['target' => '_blank']);
                    },
                ],
            ],
        ],
    ]); ?>
</div>
