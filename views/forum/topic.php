Yii::$app->formatter->asRelativeTime<?php

use app\assets\ForumAsset;
use app\components\UserPermissions;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\forum\Forum */

ForumAsset::register($this);

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'),
                                  'url' => ['/forum/index']];
$this->params['breadcrumbs'][] = ['label' => $model->category->name,
                                  'url' => ['/forum/topics', 'categoryName' => $model->category->slug]];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => Html::encode($model->meta_description),
    ]
);

?>

<div class="forum_topic">

    <div class="forum_topic__item">

        <div class="forum_topic__item__title">
            <h1>
                <?= $this->title; ?>
            </h1>
        </div>

        <?php if (UserPermissions::canAdminForum() || UserPermissions::canEditForum($model)) : ?>
            <p class="forum_topic__item__title__edit"><i class="fa fa-edit"></i>
                <?= Html::a( \Yii::t('app', 'button_update'), ['/forum/update', 'id' => $model->id]); ?></p>
        <?php endif; ?>

        <div class="forum_topic__item__content">
            <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm'), ['HTML.Nofollow' => true]); ?>
        </div>

    </div>

    <div class="forum_topic__footer">
        <i class="fa fa-clock-o"></i> <?= Yii::$app->formatter->asRelativeTime($model->created_at); ?>
        <i class="fa fa-user"></i>
        <?php if (!empty($model->user_id)) : ?>
            <?= Html::a($model->user->username, ['/forum/user/' . $model->user->username]); ?>
        <?php else : ?>
            <?= \Yii::t('app', 'user_anonym'); ?>
        <?php endif; ?>
        <?php if (isset($model->category->name)) : ?>
            <i class="fa fa-folder"></i>
            <?= Html::a($model->category->name, '/forum/topics/' . $model->category->slug); ?>
        <?php endif; ?>
        <?php if ($model->commentsCount > 0) : ?>
            <i class="fa fa-comments"></i> <?= Html::encode($model->commentsCount); ?>
        <?php endif; ?>
    </div>

    <?= $this->render('_comments', ['model' => $model]); ?>

</div>