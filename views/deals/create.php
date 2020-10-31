<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\deals\Deals */

$this->title = \Yii::t('app/deals', 'page_create_deals_title');

$this->params['breadcrumbs'][] = Html::encode($this->title);

?>
<div class="deals-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model,]) ?>
</div>
