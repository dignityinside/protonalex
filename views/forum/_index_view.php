<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\category\Category */

$this->params['breadcrumbs']['index'] = \Yii::t('app/forum', 'breadcrumbs_forum_index');

$icon = $model->icon ?? 'fas fa-folder';

?>
<div class="forum_index_list__item">
    <div class="forum_index_list__item__icon">
        <?= Html::a('<i class="' . $icon . '" aria-hidden="true"></i>', ['/forum/topics', 'categoryName' => $model->slug]); ?>
    </div>
    <div class="forum-index-list__item__name">
        <h3><?= Html::a($model->name, ['/forum/topics', 'categoryName' => $model->slug]); ?></h3>
        <p><?= Html::encode($model->description); ?></p>
    </div>
</div>
