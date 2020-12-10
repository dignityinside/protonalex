<?php

use yii\helpers\Html;
use app\assets\ForumAsset;
use yii\helpers\Url;
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

if (isset($categoryModel)) {
    $this->registerMetaTag(['name' => 'description', 'content' => $categoryModel->description]);
    $this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1']);

    $this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['/forum/topics/' . $categoryModel->slug], true)]);
}

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'), 'url' => ['index']];
$this->params['breadcrumbs'][] = isset($categoryModel) ? $categoryName : \Yii::t('app/forum', 'forum_new_topics_text');

?>
<div class="forum_topics">

    <div class="forum_topics_header text-center">
        <h1><i class="fa fa-folder"></i> <?= $this->title; ?></h1>
    </div>

    <p class="text-center">
        <?= Html::a('<i class="fas fa-plus"></i> ' . \Yii::t('app/forum', 'forum_button_new_topic'),
            ['create', 'id' => $categoryId], ['class' => 'btn btn-success']); ?>
        <?= Html::a('<i class="fa fa-folder"></i> ' . \Yii::t('app/forum', 'forum_button_categories'),
            ['/forum'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fa fa-clock"></i> ' . \Yii::t('app/forum', 'forum_button_new_topics'),
            ['topics', 'categoryName' => 'new'], ['class' => 'btn btn-default']); ?>
        <?= Html::a('<i class="fas fa-crown"></i> ' . \Yii::t('app/forum', 'forum_button_my_topics'),
            ['my'], ['class' => 'btn btn-default']); ?>
    </p>

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