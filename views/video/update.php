<?php

use app\assets\VideoAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\video\Video */

VideoAsset::register($this);

$this->title = 'Обновить видео';

$this->params['breadcrumbs'][] = ['label' => 'Мои видео', 'url' => ['my']];
$this->params['breadcrumbs'][] = 'Обновить';


?>
<div class="post-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model]) ?>

</div>
