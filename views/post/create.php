<?php

use yii\helpers\Html;
use app\components\UserPermissions;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = \Yii::t('app/blog', 'title_add_new_post');

$this->params['breadcrumbs'][] = ['label' => \Yii::t('app/blog', 'posts'), 'url' => ['admin']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>
<div class="post-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?php if (Yii::$app->session->hasFlash('success')): ?>
        <div class="alert alert-success">
            <i class="fa fa-check"></i>
            <?= Yii::$app->session->getFlash('success') ?>
        </div>
    <?php endif; ?>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
