<?php

use yii\helpers\Html;
use app\components\UserPermissions;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = \Yii::t('app/blog', 'title_update_post');

if (UserPermissions::canAdminPost()) {
    $this->params['breadcrumbs'][] = ['label' => \Yii::t('app/blog', 'posts'), 'url' => ['admin']];
}

$this->params['breadcrumbs'][] = \Yii::t('app/blog', 'title_update_post');

?>
<div class="post-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', ['model' => $model]) ?>
</div>
