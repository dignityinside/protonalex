<?php

use yii\helpers\Html;

/** @var $this yii\web\View */
/** @var $model app\models\Deals */

if ($model->thumbnail) {

    echo Html::a(Html::img(Html::encode($model->thumbnail), [
        'alt' => Html::encode($model->title),
        'title' => Html::encode($model->title),
    ]), '/deals/view/' . Html::encode($model->id));

}
