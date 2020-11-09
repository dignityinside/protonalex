<?php

use app\components\UserPermissions;
use app\helpers\Text;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => 'Блог', 'url' => ['/post/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name'    => 'description', 'content' => $model->meta_description]);

?>
<div class="post-view">

    <h1><?= $this->title; ?></h1>

    <?php if (UserPermissions::canAdminPost()) : ?>
        <p><i class="fa fa-edit"></i>
            <?= Html::a('Изменить', ['post/update', 'id' => $model->id]); ?></p>
    <?php endif; ?>

    <?php if ($model->isPremium()) : ?>
        <?= Text::hidecut(HtmlPurifier::process(Markdown::process($model->content, 'gfm'))); ?>
        <?php if (\Yii::$app->user->identity === null && $model->ontop) : ?>
            <?= $this->render('_ad') ?>
        <?php endif; ?>

        <?php if ($model->ontop) : ?>
            <?= $this->render('/partials/share'); ?>
        <?php endif; ?>
    <?php else : ?>
        <?= Text::cut(HtmlPurifier::process(Markdown::process($model->content, 'gfm'))); ?>
        <div class="alert alert-danger">
            Скрытое содержимое могут видеть только премиум пользователи.
            <p>
                <?php if (\Yii::$app->user->identity === null) : ?>
                    <?= Html::a('Уже премиум? Войди на сайт!', '/login') ?> |
                <?php endif; ?>
                <?= Html::a('Получить премиум', '/premium') ?>
            </p>
        </div>
    <?php endif; ?>

    <?php if ($model->ontop) : ?>
        <?= $this->render('_post_footer', ['model' => $model]); ?>
    <?php endif; ?>

    <?php if ($model->commentsAllowed()) : ?>
        <?= $this->render('_comments', ['model' => $model]); ?>
    <?php endif; ?>

</div>
