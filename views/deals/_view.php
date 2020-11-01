<?php

use yii\helpers\Html;
use yii\helpers\HtmlPurifier;
use yii\helpers\Markdown;
use app\helpers\Text;

/** @var $this yii\web\View */
/** @var $model app\models\deals\Deals */

?>

<div class="deals-view">

    <div class="deals-view-item">

        <div class="deals-view-item-left">

            <div class="deals-view-title">
                <?= Html::a($model->title, ['deals/view', 'id' => $model->id]); ?>
                <?= Html::encode($model->getDiscount()); ?>
            </div>

            <div class="deals-view-footer">
                <i class="fa fa-clock-o"></i> <?= date('d.m.Y', Html::encode($model->created)); ?>
                <i class="fa fa-eye"></i> <?= Html::encode($model->hits); ?>
                <?php if ($model->commentsCount > 0) : ?>
                    <i class="fa fa-comments"></i> <?= Html::encode($model->commentsCount); ?>
                <?php endif; ?>
            </div>

            <div class="deals-view-content">
                <?= Text::xcut(Html::encode($model->content)); ?>
            </div>

            <?php if ($model->content) : ?>
                <div class="deals-view-more">
                    <?= Html::a(\Yii::t('app', 'button_more'), ['/deals/view', 'id' => $model->id]); ?>
                </div>
            <?php endif; ?>

        </div>

        <div class="deals-view-item-right">

            <div class="deals-view-thumbnail">
                <?= $this->render('partials/thumbnail', ['model' => $model]); ?>
            </div>

            <div class="deals-view-button">
                <?= $this->render('partials/button', ['model' => $model]); ?>
            </div>

        </div>

    </div>

</div>
