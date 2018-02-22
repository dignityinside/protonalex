<?php

use app\widgets\Avatar;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
?>
<div class="user-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget(
        [
            'dataProvider' => $dataProvider,
            'columns'      => [
                [
                    'format' => 'raw',
                    'label' => 'Пользователь',
                    'attribute' => 'username',
                    'value' => function ($model) {
                        return Html::a(
                            Avatar::widget(['user' => $model]) . ' ' . Html::encode($model->username),
                            ['user/view', 'id' => $model->id]
                        );
                    }
                ],
                'email:email',
                [
                    'format' => 'raw',
                    'label'  => 'GitHub',
                    'value'  => function ($model) {
                        return Html::a(Html::encode($model->getGithubProfileUrl()), $model->getGithubProfileUrl());
                    }
                ],
                [
                    'attribute' => 'status',
                    'label'     => 'Статус',
                    'value'     => function ($model) {
                        return $model->getStatusLabel();
                    }
                ],
                [
                    'attribute' => 'created_at',
                    'label'     => 'Создан',
                    'value'     => function ($model) {
                        return Yii::$app->formatter->asDate($model->created_at);
                    }
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update}{delete}'],
            ],
        ]
    ) ?>

</div>
