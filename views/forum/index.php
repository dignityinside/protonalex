<?php

use yii\helpers\Html;
use app\assets\ForumAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/forum', 'page_forum_index_title');

ForumAsset::register($this);

?>

<div class="forum_index">

    <div class="forum-index-header text-center">
        <h1><i class="fas fa-comments"></i> <?= $this->title ?></h1>
    </div>

    <p class="text-center">
        <?= Html::a('<i class="fas fa-plus"></i> ' . \Yii::t('app/forum', 'forum_button_new_topic'),
            ['create'], ['class' => 'btn btn-success']); ?>
        <?= Html::a('<i class="fa fa-clock"></i> ' . \Yii::t('app/forum', 'forum_button_new_topics'),
            ['topics', 'categoryName' => 'new'],
            ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-comment-slash"></i> ' . \Yii::t('app/forum', 'forum_button_no_answer'),
            ['topics', 'categoryName' => 'new', 'sortBy' => 'unanswered'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-crown"></i> ' . \Yii::t('app/forum', 'forum_button_my_topics'),
            ['my'], ['class' => 'btn btn-default']); ?>
    </p>
    <div class="forum_index_list">
        <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText'    => \Yii::t('app/forum', 'forum_index_list_empty_text'),
                'itemView'     => '_index_view',
                'layout'       => "{items}{pager}",
            ]
        ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
