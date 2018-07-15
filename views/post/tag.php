<?php

use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var string $tagName */

$this->title = sprintf('Записи с меткой: %s', $tagName);

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => strtolower($tagName),
    ]
);

?>
<div class="post-index">

    <h1><i class="fa fa-tags"></i> <?= $tagName; ?></h1>

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
