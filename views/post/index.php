<?php

use yii\helpers\Html;
use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Блог | ' . \Yii::$app->params['siteName'];

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => '',
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => '',
    ]
);

?>
<div class="post-index">

    <ul class="post-filter">
        <li><?= Html::a('<i class="fa fa-clock"></i>Новые', '/post/index') ?></li>
        <li><?= Html::a('<i class="fa fa-eye"></i>Популярные', '/post/index/1') ?></li>
        <li><?= Html::a('<i class="fa fa-comments"></i>Обсуждаемые', '/post/index/2') ?></li>
    </ul>

    <?php Pjax::begin(); ?>
    <?= ListView::widget(
        [
            'dataProvider' => $dataProvider,
            'emptyText'    => 'Записи не найдены.',
            'itemView'     => '_view',
            'layout' => "{items}{pager}",
        ]
    ); ?>
    <?php Pjax::end(); ?>
</div>
