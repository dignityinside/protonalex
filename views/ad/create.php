<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\category\Category */

$this->title = \Yii::t('app/ad', 'page_create_ad_title');

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/ad', 'breadcrumbs_label_admin_ad'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>
<div class="category-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
