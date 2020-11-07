<?php

use app\assets\VideoAsset;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\post\Post */

VideoAsset::register($this);

$this->title = 'Добавить видео';

$this->params['breadcrumbs'][] = ['label' => 'Мои видео', 'url' => ['my']];
$this->params['breadcrumbs'][] = Html::encode($this->title);


?>
<div class="video-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', ['model' => $model,]) ?>

</div>
