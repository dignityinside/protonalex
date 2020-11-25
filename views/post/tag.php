<?php

use yii\helpers\Url;
use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $tag \app\models\Tag */

$tagName = $tag->name;

$this->title = sprintf('Записи с тэгом: %s', $tagName);

$this->registerMetaTag(['name' => 'title', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $this->title]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(['tag/' . $tag->slug], true)]);
?>
<div class="post-index">

    <div class="post-header text-center">
        <h1><i class="fa fa-tags"></i> <?= $tagName; ?></h1>
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
