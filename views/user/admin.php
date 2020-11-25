<?php

use app\widgets\Avatar;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
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
                    'value' => static function ($model) {
                        return Html::a(
                            Avatar::widget(['user' => $model]) . ' ' . Html::encode($model->username),
                            ['user/view', 'id' => $model->id]
                        );
                    }
                ],
                'email:email',
                [
                    'attribute' => 'created_at',
                    'label'     => 'Создан',
                    'value'     => static function ($model) {
                        return Yii::$app->formatter->asDate($model->created_at);
                    }
                ],
                [
                    'attribute' => 'status',
                    'label'     => 'Статус',
                    'value'     => static function ($model) {
                        return $model->getStatusLabel();
                    }
                ],
                [
                    'format' => 'raw',
                    'label'  => 'Premium',
                    'value'  => static function ($model) {
                        return $model->premium ? 'Да' : 'Нет';
                    }
                ],
                [
                    'attribute' => 'premium_until',
                    'label'     => 'Оплачен до',
                    'format'    => 'raw',
                    'value'     => static function ($model) {
                        return Yii::$app->formatter->asDate($model->premium_until);
                    },
                ],
                ['class' => 'yii\grid\ActionColumn', 'template' => '{view}{update}{delete}'],
            ],
        ]
    ) ?>

</div>
