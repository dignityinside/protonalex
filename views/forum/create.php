<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forum\Forum */

$this->title = \Yii::t('app/forum', 'page_forum_create_title');

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_my'), 'url' => ['my']];
$this->params['breadcrumbs'][] = Html::encode($this->title);

?>
<div class="forum-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model, 'categoryId' => $categoryId]) ?>
</div>
