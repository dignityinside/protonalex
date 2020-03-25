<?php

use yii\helpers\Html;
use yii\grid\GridView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Записи';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="post-admin">

    <h1><?= Html::encode($this->title) ?></h1>
    <?php echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a('Добавить новую запись', ['create'], ['class' => 'btn btn-success']) ?>
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
                    'label' => 'Комментарий',
                    'value' => function ($model) {
                        return $model->commentsCount;
                    }
                ],
                [
                    'attribute' => 'ontop',
                    'label'     => 'На главной',
                    'value'     => function ($model) {
                        return $model->ontop ? 'Да' : 'Нет';
                    }
                ],

                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view} {update} {delete}',
                        'buttons' => [
                            'view' => function ($url, $model) {
                                return Html::a(
                                    '<span class="glyphicon glyphicon-eye-open"></span>',
                                    ['post/view', 'slug' => $model->slug]);
                            },
                        ],
                ],

            ],
        ]
    ); ?>
    <?php Pjax::end(); ?></div>
