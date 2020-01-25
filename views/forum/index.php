<?php

use yii\helpers\Html;
use app\assets\ForumAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Руланд форум';

ForumAsset::register($this);

?>

<div class="forum_index">

    <div class="forum-index-header text-center">
        <h1><i class="fas fa-comments"></i> <?= $this->title ?></h1>
    </div>

    <p class="text-center">
        <?= Html::a('<i class="fas fa-plus"></i> Новая тема', ['create'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('<i class="fa fa-clock"></i> Новые темы', ['topics', 'categoryName' => 'new'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-comment-slash"></i> Без ответов', ['topics', 'categoryName' => 'new', 'sortBy' => 'unanswered'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-crown"></i> Мои темы', ['my'], ['class' => 'btn btn-default']); ?>
    </p>
    <div class="forum_index_list">
        <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText'    => 'Разделы форума не найдены.',
                'itemView'     => '_index_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
