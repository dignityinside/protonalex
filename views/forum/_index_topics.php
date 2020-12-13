<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\models\forum\Forum */

?>

<div class="forum_topics_list__item">
    <div class="forum_topics_list__item__icon">
        <i class="fas fa-file"></i>
    </div>
    <div class="forum_topics_list__item__name">
        <div class="forum_topics_list__item__name__title">
            <?= Html::a($model->title, ['forum/topic', 'id' => $model->id]); ?>
        </div>
        <div class="forum_topics_list__item__name__user">
            <span>
                <i class="fa fa-clock-o"></i> <?= $model->getFormattedCreatedAt(); ?>
            </span>
            <span>
                <i class="fa fa-user"></i>
                <?php if (!empty($model->user_id)) : ?>
                    <?= Html::a($model->user->username, ['/forum/user/' . $model->user->username]); ?>
                <?php else : ?>
                    <?= \Yii::t('app', 'user_anonym'); ?>
                <?php endif; ?>
            </span>
            <span>
                <?php if (isset($model->category->name)) : ?>
                    <i class="fa fa-folder"></i> <?= Html::a($model->category->name, '/forum/topics/' . $model->category->slug); ?>
                <?php endif; ?>
            </span>
        </div>
    </div>
    <div class="forum_topics_list__item__comments">
        <span><i class="fa fa-comments"></i> <?= Html::encode($model->commentsCount); ?></span>
    </div>
    <div class="forum_topics_list__item__hits">
        <span><i class="fa fa-eye"></i> <?= Html::encode($model->hits); ?></span>
    </div>
</div>