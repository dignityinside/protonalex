<?php

use \yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\VideoAsset;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */
/** @var string $userName */

VideoAsset::register($this);

$this->title = 'Видео пользователя ' . $userName;

?>

<div class="video-index">
    <h1><i class="fa fa-youtube"></i> Видео пользователя <?= $userName ?></h1>
    <div class="video-index-list">
        <?php Pjax::begin(); ?>
            <?= ListView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Видео не найдены.',
                    'itemView' => '_view',
                    'layout' => "{items}{pager}",
                ]
            ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
