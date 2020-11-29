<?php

use app\models\ad\Ad;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ad\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/ad', 'page_admin_ad_title');

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

?>
<div class="ad-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('app/ad', 'button_create_ad'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            [
                'attribute' => 'title',
                'label' => \Yii::t('app/ad', 'title'),
                'contentOptions' => ['class' => 'is-breakable'],
                'value' => function ($model) {
                    return $model->title;
                }
            ],
             [
                'attribute' => 'url',
                'label' => \Yii::t('app/ad', 'url'),
                'contentOptions' => ['class' => 'is-breakable'],
                'value' => function ($model) {
                    return $model->url;
                }
            ],
            [
                'attribute' => 'slot',
                'label' => \Yii::t('app/ad', 'slot'),
                'contentOptions' => ['class' => 'is-breakable'],
                'value' => function ($model) {
                    return ArrayHelper::getValue([
                        Ad::SLOT_SIDEBAR => \Yii::t('app/ad', 'sidebar'),
                        Ad::SLOT_POST_BOTTOM => \Yii::t('app/ad', 'post_bottom')
                    ], $model->slot);
                }
            ],
            [
                'attribute' => 'status',
                'label' => \Yii::t('app/ad', 'status'),
                'contentOptions' => ['class' => 'is-breakable'],
                'value' => function ($model) {
                    return $model->getStatusLabel();
                }
            ],
            'hits',
            'views',
            'clicks',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {view} {delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                            '<span class="glyphicon glyphicon-eye-open"></span>',
                            ['ad/view', 'slug' => $model->slug],
                            ['target' => '_blank']
                        );
                    },
                ],
            ],
        ],
    ]); ?>
</div>
