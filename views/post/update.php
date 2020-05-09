<?php

use yii\helpers\Html;
use app\components\UserPermissions;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

$this->title = 'Обновить запись';

if (UserPermissions::canAdminPost()) {
    $this->params['breadcrumbs'][] = ['label' => 'Записи', 'url' => ['admin']];
} else {
    $this->params['breadcrumbs'][] = ['label' => 'Записи', 'url' => ['my']];
}
$this->params['breadcrumbs'][] = 'Обновить';
?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render(
        '_form',
        [
        'model' => $model,
        ]
    ) ?>

</div>
