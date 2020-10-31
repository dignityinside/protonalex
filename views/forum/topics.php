<?php

use yii\helpers\Html;
use app\assets\ForumAsset;
use yii\widgets\ListView;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var \app\models\category\Category $categoryModel */

ForumAsset::register($this);

$categoryName = isset($categoryModel)
    ? Html::encode($categoryModel->name)
    : \Yii::t('app/forum', 'forum_new_topics_text');
$categoryId = isset($categoryModel) ? $categoryModel->id : 0;
$categorySlug = isset($categoryModel) ? $categoryModel->slug : 'new';

$this->title = isset($categoryModel)
    ? \Yii::t('app/forum', 'page_forum_topic_title') . ' - ' . $categoryName
    : \Yii::t('app/forum', 'forum_new_topics_text');

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => $this->title,
    ]
);

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'), 'url' => ['index']];

?>
<div class="forum_topics">

    <div class="forum_topics_header text-center">
        <h1><i class="fa fa-folder"></i> <?= $this->title; ?></h1>
    </div>

    <?php if ($dataProvider->totalCount > 0) : ?>
        <ul class="forum_topics_filter">
            <li><?= Html::a('<i class="fa fa-clock"></i> ' . \Yii::t('app', 'sort_new'),
                ['/forum/topics/', 'categoryName' => $categorySlug]) ?></li>
            <li><?= Html::a('<i class="fa fa-eye"></i> ' . \Yii::t('app', 'sort_hits'),
                '/forum/topics/' . $categorySlug . '/hits') ?></li>
            <li><?= Html::a('<i class="fa fa-comments"></i> ' . \Yii::t('app', 'sort_comments'),
                '/forum/topics/' . $categorySlug . '/comments') ?></li>
            <li><?= Html::a('<i class="fas fa-comment-slash"></i></i> ' . \Yii::t('app/forum', 'forum_sort_no_answer'),
                '/forum/topics/' .  $categorySlug . '/unanswered') ?></li>
        </ul>

    <?php endif; ?>

    <p class="text-center">
        <?= Html::a('<i class="fas fa-plus"></i> ' . \Yii::t('app/forum', 'forum_button_new_topic'),
            ['create', 'id' => $categoryId], ['class' => 'btn btn-success']); ?>
        <?= Html::a('<i class="fa fa-clock"></i> ' . \Yii::t('app/forum', 'forum_button_new_topics'),
            ['topics', 'categoryName' => 'new'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-comment-slash"></i> ' . \Yii::t('app/forum', 'forum_button_no_answer'),
            ['topics', 'categoryName' => 'new', 'sortBy' => 'unanswered'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-crown"></i> ' . \Yii::t('app/forum', 'forum_button_my_topics'),
            ['my'], ['class' => 'btn btn-default']); ?>
    </p>

    <div class="forum_topics_list">
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText'    => \Yii::t('app/forum', 'forum_category_list_empty_text'),
                'itemView'     => '_index_topics',
                'layout' => "{items}{pager}",
            ]
        ); ?>
    </div>
</div>
