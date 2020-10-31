<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\deals\Deals */

$this->title = \Yii::t('app/deals', 'page_deals_update_title');

$this->params['breadcrumbs'][] = \Yii::t('app', 'breadcrumbs_label_update');

?>

<div class="post-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
