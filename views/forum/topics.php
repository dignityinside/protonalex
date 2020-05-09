<?php

use yii\helpers\Html;
use app\assets\ForumAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\category\Category $categoryModel */

ForumAsset::register($this);

$categoryName = isset($categoryModel) ? Html::encode($categoryModel->name) : 'Новые темы';
$categoryId = isset($categoryModel) ? $categoryModel->id : 0;
$categorySlug = isset($categoryModel) ? $categoryModel->slug : 'new';

$this->title = isset($categoryModel) ? 'Руланд форум - ' . $categoryName : 'Новые темы';

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->params['breadcrumbs'][] = ['label' => 'Форум', 'url' => ['index']];

?>
<div class="forum_topics">

    <div class="forum_topics_header text-center">
        <h1><i class="fa fa-folder"></i> Руланд форум - <?= $categoryName; ?></h1>
    </div>

    <?php if ($dataProvider->totalCount > 0) : ?>
        <ul class="forum_topics_filter">
            <li><?= Html::a('<i class="fa fa-clock"></i>Новые', ['/forum/topics/', 'categoryName' => $categorySlug]) ?></li>
            <li><?= Html::a('<i class="fa fa-eye"></i>Популярные', '/forum/topics/' . $categorySlug . '/hits') ?></li>
            <li><?= Html::a('<i class="fa fa-comments"></i>Обсуждаемые', '/forum/topics/' . $categorySlug . '/comments') ?></li>
            <li><?= Html::a('<i class="fas fa-comment-slash"></i></i>Без ответов', '/forum/topics/' .  $categorySlug . '/unanswered') ?></li>
        </ul>

    <?php endif; ?>

    <p class="text-center">
        <?= Html::a('<i class="fas fa-plus"></i> Новая тема', ['create', 'id' => $categoryId], ['class' => 'btn btn-success']); ?>
        <?= Html::a('<i class="fa fa-clock"></i> Новые темы', ['topics', 'categoryName' => 'new'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-comment-slash"></i> Без ответов', ['topics', 'categoryName' => 'new', 'sortBy' => 'unanswered'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-crown"></i> Мои темы', ['my'], ['class' => 'btn btn-default']); ?>
    </p>

    <div class="forum_topics_list">
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText'    => 'В данном форуме пока что нету тем.',
                'itemView'     => '_index_topics',
                'layout' => "{items}{pager}",
            ]
        ); ?>
    </div>
</div>
