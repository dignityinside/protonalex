<?php

use app\components\UserPermissions;
use app\helpers\Text;
use app\models\ad\Ad;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['/post/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'robots', 'content' => 'index, follow, max-snippet:-1, max-image-preview:large, max-video-preview:-1']);

$currentPage = Url::to(['post/view', 'slug' => $model->slug], true);

$this->registerLinkTag(['rel' => 'canonical', 'href' => $currentPage]);

/**
 * https://developer.twitter.com/en/docs/twitter-for-websites/cards/guides/getting-started
 * https://cards-dev.twitter.com/validator
 */
$this->registerMetaTag(['name' => 'twitter:card', 'content' => 'summary_large_image']);
$this->registerMetaTag(['name' => 'twitter:site', 'content' => \Yii::$app->params['site']['twitter']]);
$this->registerMetaTag(['name' => 'twitter:domain', 'content' => \Yii::$app->params['site']['description']]);
$this->registerMetaTag(['name' => 'twitter:creator', 'content' => \Yii::$app->params['site']['twitter']]);
$this->registerMetaTag(['name' => 'twitter:url', 'content' => $currentPage]);
$this->registerMetaTag(['name' => 'twitter:title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'twitter:description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'twitter:image:src', 'content' => \Yii::$app->params['site']['url'] . $model->preview_img]);

/**
 * https://ogp.me
 */
$this->registerMetaTag(['name' => 'og:type', 'content' => 'article']);
$this->registerMetaTag(['name' => 'og:title', 'content' => $model->title]);
$this->registerMetaTag(['name' => 'og:description', 'content' => $model->meta_description]);
$this->registerMetaTag(['name' => 'og:url', 'content' => $currentPage]);
$this->registerMetaTag(['name' => 'og:site_name', 'content' => \Yii::$app->params['site']['name']]);
$this->registerMetaTag(['name' => 'og:locale', 'content' => Yii::$app->language]);
$this->registerMetaTag(['name' => 'og:image', 'content' => \Yii::$app->params['site']['url'] . $model->preview_img]);
$this->registerMetaTag(['name' => 'og:image:width', 'content' => '806']);
$this->registerMetaTag(['name' => 'og:image:height', 'content' => '327']);
$this->registerMetaTag(['name' => 'og:image:alt', 'content' => $model->title]);
?>
<div class="post-view">

    <h1><?= $this->title; ?></h1>

    <?php if (UserPermissions::canAdminPost()) : ?>
        <p><i class="fa fa-edit"></i>
            <?= Html::a('Изменить', ['post/update', 'id' => $model->id]); ?></p>
    <?php endif; ?>

    <?php if (!empty($model->preview_img)) : ?>
        <p><img src="/<?= $model->preview_img; ?>" alt="<?= $model->title ?>"></p>
    <?php endif; ?>

    <?php if ($model->isPremium()) : ?>

        <?= Text::hidecut('[cut]',
            Text::hideCut('[premium]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'), ['HTML.Nofollow' => true]))
        ); ?>

        <?php if ($model->ontop) : ?>
            <hr>
            <?= $this->render('/partials/subscribe'); ?>
            <?= $this->render('/partials/share'); ?>
            <?= app\widgets\Ad::widget(['slot' => Ad::SLOT_POST_BOTTOM]); ?>
        <?php endif; ?>

    <?php else : ?>
        <?= Text::hidecut('[cut]',
            Text::cut('[premium]', HtmlPurifier::process(Markdown::process($model->content, 'gfm'), ['HTML.Nofollow' => true]))
        ); ?>
        <?= $this->render('../partials/premium'); ?>
    <?php endif; ?>

    <?php if ($model->ontop) : ?>
        <?= $this->render('_post_footer', ['model' => $model]); ?>
    <?php endif; ?>

    <?php if ($model->commentsAllowed()) : ?>
        <?= $this->render('_comments', ['model' => $model]); ?>
    <?php endif; ?>

</div>
