<?php

use yii\helpers\Html;
use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Список записей';

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => 'Список записей',
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => 'Список записей',
    ]
);

?>
<div class="post-index">
    <?php Pjax::begin(); ?>
    <?= ListView::widget(
        [
            'dataProvider' => $dataProvider,
            'emptyText'    => 'Записи не найдены.',
            'itemView'     => '_view',
        ]
    ); ?>
    <?php Pjax::end(); ?>
</div>
