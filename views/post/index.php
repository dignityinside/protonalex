<?php

use app\components\UserPermissions;
use yii\helpers\Html;
use yii\helpers\Url;
use \yii\widgets\ListView;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel app\models\post\PostSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::$app->params['site']['name'];

$this->registerMetaTag(['name' => 'title', 'content' => \Yii::$app->params['site']['name']]);
$this->registerMetaTag(['name' => 'description', 'content' => \Yii::$app->params['site']['description']]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1']);

$this->registerLinkTag(['rel' => 'canonical', 'href' => Url::to(\Yii::$app->params['site']['url'])]);
?>
<div class="post-index">

    <div class="post-header text-center">
        <h1>
            <?php if (UserPermissions::canAdminPost()) : ?>
                <?= Html::a('<i class="fas fa-feather" style="color: #4eb26b"></i>', ['/post/create']) ?>
            <?php else : ?>
                <i class="fas fa-feather"></i>
            <?php endif; ?>
            <?= \Yii::$app->params['site']['name'] ?>
        </h1>
    </div>

    <ul class="post-filter">
        <li><?= Html::a('<i class="fa fa-clock"></i>Новые', '/post/index') ?></li>
        <li><?= Html::a('<i class="fa fa-eye"></i>Популярные', '/post/index/1') ?></li>
        <li><?= Html::a('<i class="fa fa-comments"></i>Обсуждаемые', '/post/index/2') ?></li>
    </ul>

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
