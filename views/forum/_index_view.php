<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\category\Category */

?>
<div class="forum_index_list__item">
    <div class="forum_index_list__item__icon">
        <?= Html::a('<i class="fas fa-folder"></i>', ['/forum/topics', 'categoryName'=>$model->slug]); ?>
    </div>
    <div class="forum-index-list__item__name">
        <h3><?= Html::a($model->name, ['/forum/topics', 'categoryName'=>$model->slug]); ?></h3>
        <p><?= Html::encode($model->description); ?></p>
    </div>
</div>
