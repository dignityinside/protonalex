<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\models\deals\Deals */

$expired = $model->url && $model->isExpired();
$class = ($expired) ? 'disabled' : 'btn-success';

echo Html::a(
    \Yii::t('app/deals', 'button_text_go_to_deal') . ' <i class="fa fa-external-link"></i>',
    Html::encode($model->url),
    [
    'class' => 'btn ' . $class,
    'title' => \Yii::t('app/blog', 'button_title_go_to_deal'),
    'target' => '_blank',
    'rel' => 'nofollow'
    ]
);
