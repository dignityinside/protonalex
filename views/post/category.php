<?php

use yii\helpers\Url;
use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $category \app\models\category\Category */

$categoryName = $category->name;

$this->title = sprintf('Записи из категории: %s', $categoryName);

$this->registerMetaTag(['name' => 'title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $category->description]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1']);

$currentPage = Url::to(['category/' . $category->slug], true);
$this->registerLinkTag(['rel' => 'canonical', 'href' => $currentPage]);

/**
 * https://ogp.me
 */
$this->registerMetaTag(['name' => 'og:type', 'content' => 'object']);
$this->registerMetaTag(['name' => 'og:title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $category->description]);
$this->registerMetaTag(['name' => 'og:url', 'content' => $currentPage]);
$this->registerMetaTag(['name' => 'og:site_name', 'content' => \Yii::$app->params['site']['name']]);
$this->registerMetaTag(['name' => 'og:locale', 'content' => Yii::$app->language]);

?>
<div class="post-index">
    <div class="post-header text-center">
        <h1><i class="fas fa-folder"></i> <?= $categoryName; ?></h1>
        <p><?= $category->description ?></p>
    </div>
    <?php Pjax::begin(); ?>
        <?= ListView::widget(
            [
                'dataProvider' => $dataProvider,
                'emptyText'    => \Yii::t('app/blog', 'records_not_found'),
                'itemView'     => '_view',
                'layout' => "{items}{pager}",
            ]
        ); ?>
    <?php Pjax::end(); ?>
</div>
