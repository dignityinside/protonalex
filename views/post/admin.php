<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/blog', 'posts');
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>
<div class="post-admin">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('app/blog', 'button_add_new_post'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'filterModel'  => $searchModel,
            'columns'      => [
                ['class' => 'yii\grid\SerialColumn'],
                'title',
                [
                    'attribute' => 'status_id',
                    'label'     => \Yii::t('app/blog', 'status_id'),
                    'value'     => function ($model) {
                        return $model->getStatusLabel();
                    }
                ],
                [
                    'attribute' => 'hits',
                    'label' => \Yii::t('app/blog', 'hits'),
                    'value' => function ($model) {
                        return $model->hits;
                    }
                ],
                [
                    'attribute' => 'comments',
                    'label' => \Yii::t('app/blog', 'comments'),
                    'value' => function ($model) {
                        return $model->commentsCount;
                    }
                ],
                [
                    'attribute' => 'ontop',
                    'label'     => \Yii::t('app/blog', 'ontop'),
                    'value'     => function ($model) {
                        return $model->ontop ? \Yii::t('app', 'yes') : \Yii::t('app', 'no');
                    }
                ],

                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>',
                                    ['post/view', 'slug' => $model->slug]
                                );
                            },
                        ],
                ],

            ],
        ]
    ); ?>
    <?php Pjax::end(); ?></div>
