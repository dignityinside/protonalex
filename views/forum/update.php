<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\forum\Forum */

$this->title = 'Обновить тему';

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_index'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/forum', 'breadcrumbs_forum_my'), 'url' => ['my']];
$this->params['breadcrumbs'][] = \Yii::t('app', 'breadcrumbs_label_update');

?>

<div class="forum-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
