<?php

use app\components\UserPermissions;
use yii\helpers\Html;
use yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\VideoAsset;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

VideoAsset::register($this);

$this->title = 'Руланд видео';
;


?>

<div class="video-index">

    <div class="post-header text-center">
        <h1>
            <?php if (UserPermissions::canAdminPost()) : ?>
                <?= Html::a('<i class="fa fa-youtube" style="color: #fff"></i>', ['/video/create']) ?>
            <?php else : ?>
                <i class="fa fa-youtube"></i>
            <?php endif; ?>
            <?= $this->title ?>
        </h1>
    </div>

    <ul class="video-index-filter">
        <li><?= Html::a('<i class="fa fa-clock"></i>Новые', '/video') ?></li>
        <li><?= Html::a('<i class="fa fa-eye"></i>Популярные', '/video/hits') ?></li>
        <li><?= Html::a('<i class="fa fa-comments"></i>Обсуждаемые', '/video/comments') ?></li>
        <li><?= Html::a('<i class="far fa-clock"></i>Старые', '/video/old') ?></li>
    </ul>
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
