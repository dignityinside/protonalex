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
<div class="post-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Добавить новую запись', ['create'], ['class' => 'btn btn-success']) ?>
    </p>
    <?php Pjax::begin(); ?>
    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns'      => [
                'title',
                [
                    'attribute' => 'status_id',
                    'label'     => 'Статус',
                    'value'     => function ($model) {
                        return $model->getStatusLabel();
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'label'     => 'Создан',
                    'value'     => function ($model) {
                        return Yii::$app->formatter->asDate($model->datecreate);
                    }
                ],
                'hits',
                [
                        'class' => 'yii\grid\ActionColumn',
                        'template' => '{view}{update}',
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
    ) ?>
    <?php Pjax::end(); ?></div>
