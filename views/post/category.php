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
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['category/' . $category->slug], true)]);
?>
<div class="post-index">
    <div class="post-header text-center">
        <h1><i class="fas fa-folder"></i> <?= $categoryName; ?></h1>
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
