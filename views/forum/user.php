<?php

use yii\helpers\Html;
use \yii\widgets\ListView;
use yii\widgets\Pjax;
use app\assets\ForumAsset;

/** @var $this yii\web\View */
/** @var $dataProvider yii\data\ActiveDataProvider */
/** @var string $userName */

$this->title = 'Темы пользователя ' . Html::encode($userName);

ForumAsset::register($this);

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="forum_topics">
    <h1><i class="fa fa-user"></i> Темы пользователя <?= Html::encode($userName) ?></h1>
    <div class="forum_topics_list">
        <?php Pjax::begin(); ?>
            <?= ListView::widget(
                [
                    'dataProvider' => $dataProvider,
                    'emptyText' => 'Темы не найдены.',
                    'itemView' => '_index_topics',
                    'layout' => "{items}{pager}",
                ]
            ); ?>
        <?php Pjax::end(); ?>
    </div>
</div>
