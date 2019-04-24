<?php

use yii\helpers\Html;
use app\assets\ForumAsset;
use yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Форум';

ForumAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];

?>

<div class="forum_index">
    <h1><i class="fas fa-comments"></i> Форум</h1>
    <p>
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
