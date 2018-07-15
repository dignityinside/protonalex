<?php

use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var string $categoryName */

$this->title = sprintf('Записи из категории: %s', $categoryName);

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->registerMetaTag(
    [
        'name'    => 'keywords',
        'content' => strtolower($categoryName),
    ]
);

?>
<div class="post-index">

    <h1><i class="fa fa-folder"></i>  <?= $categoryName; ?></h1>

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
