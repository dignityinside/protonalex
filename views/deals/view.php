<?php

use app\assets\DealsAsset;
use app\components\UserPermissions;
use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;

/* @var $this yii\web\View */
/* @var $model app\models\deals\Deals */

DealsAsset::register($this);

$this->title = Html::encode($model->title);

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/deals', 'deals_breadcrumbs_label_index'),
    'url' => ['/deals/index']];

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(
    [
        'name'    => 'description',
        'content' => Html::encode($model->meta_description),
    ]
);

?>

<div class="deals-view">

    <div class="deals-view-item">

        <div class="deals-view-item-left">

            <div class="deals-view-title">
                <h1>
                    <?= $this->title; ?>
                    <?= Html::encode($model->getDiscount()); ?>
                </h1>
            </div>

            <?php if (UserPermissions::canAdmindeals() || UserPermissions::canEditdeals($model)) : ?>
                <p class="deal-view-edit"><i class="fa fa-edit"></i>
                    <?= Html::a(\Yii::t('app', 'button_update'), ['/deals/update', 'id' => $model->id]); ?></p>
            <?php endif; ?>

            <div class="deals-price">
                <?php if (
                !empty(Html::encode($model->price_before)) && !empty(Html::encode($model->price_after))
                    || Html::encode($model->price_after) == 0
) : ?>
                    <span class="price-after"><?= $model->getPrice(Html::encode($model->price_after), true) ?></span>
                    <span class="price-before"><?= $model->getPrice(Html::encode($model->price_before), true) ?></span>
                    <span><?= Html::encode($model->getDiscount()); ?></span>
                <?php endif; ?>
            </div>

            <?php if ($model->valid_until !== null && $model->valid_until !== '0000-00-00 00:00:00') : ?>
                <?php if ($model->isExpired()) : ?>
                    <div class="alert alert-info">
                        <?= \Yii::t('app/deals', 'deals_expired_text'); ?>
                    </div>
                <?php else : ?>
                    <div class="alert alert-danger">
                        <p><?= \Yii::t('app/deals', 'deals_countdown_text') ?></p>
                        <p><?= \russ666\widgets\Countdown::widget([
                                'datetime' => $model->valid_until,
                                'format' => '<span>%-D</span> дней <span>%-H</span> часов <span>%M</span> минут <span>%S</span> секунд',
                                'events' => [
                                    'finish' => 'function(){location.reload()}',
                                ],
                            ]); ?></p>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <?php if (Html::encode($model->coupon)) : ?>
                <div class="deals-coupon">
                    <?= \Yii::t('app/deals', 'deals_coupon') ?>:
                    <span><?= Html::encode($model->coupon) ?></span>
                </div>
            <?php endif; ?>

            <div class="deals-view-content">
                <?= HtmlPurifier::process(Markdown::process($model->content, 'gfm')); ?>
            </div>

            <div class="deals-view-button">
                <?= $this->render('partials/button', ['model' => $model]); ?>
            </div>

        </div>

        <div class="deals-view-item-right">

            <div class="deals-view-thumbnail">
                <?php

                if ($model->thumbnail) {
                    echo Html::a(Html::img(Html::encode($model->thumbnail), [
                        'alt' => Html::encode($model->title),
                        'title' => Html::encode($model->title),
                    ]), '/deals/view/' . Html::encode($model->id));
                }

                ?>
            </div>

            <div class="deals-view-button">
                <?= $this->render('partials/button', ['model' => $model]); ?>
            </div>

        </div>

    </div>

    <?= $this->render('/partials/share'); ?>

    <div class="deals-view-footer">
        <i class="fa fa-clock-o"></i> <?= date('d.m.Y', Html::encode($model->created)); ?>
        <i class="fa fa-user-o"></i> <?= \Yii::t('app/deals', 'deals_author') ?>:
        <?= Html::encode($model->author); ?>
        <i class="fa fa-user"></i> <?= \Yii::t('app', 'added') ?>:
        <?php if (!empty($model->user_id)) : ?>
            <?= Html::a($model->user->username, ['/deals/user/' . $model->user->username]); ?>
        <?php else : ?>
            <?= \Yii::t('app', 'user_anonym'); ?>
        <?php endif; ?>
        <?php if (isset($model->category->name)) : ?>
            <i class="fa fa-folder"></i>
            <?= Html::a($model->category->name, '/deals/category/' . $model->category->slug); ?>
        <?php endif; ?>
    </div>

    <?= $this->render('_comments', ['model' => $model]); ?>

</div>
