<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */

/* @var $exception Exception */

use app\components\UserPermissions;
use yii\helpers\Html;

$this->title = 'Ошибка';
$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);
?>
<div class="site-error">

    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= $exception->getMessage() ?></p>

    <?php if (UserPermissions::canAdminPost()) : ?>
        <p><?= Html::a('Создать страницу', ['/post/create'], ['class' => 'btn btn-success']) ?></p>
    <?php endif; ?>

</div>
