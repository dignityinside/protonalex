<?php

use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\grid\GridView;

/* @var $this yii\web\View */
/* @var $searchModel app\models\category\CategorySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = \Yii::t('app/category', 'page_admin_category_title');

$this->params['breadcrumbs'][] = $this->title;

$this->registerMetaTag(['name' => 'robots', 'content' => 'noindex']);

?>
<div class="category-admin">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_search', ['model' => $searchModel]); ?>

    <p>
        <?= Html::a(\Yii::t('app/category', 'button_create_category'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],
            'name',
            'slug',
            [
                'attribute' => 'material_id',
                'filter' => \app\models\Material::MATERIAL_MAPPING,
                'format' => 'text',
                'content' => function ($data) {
                    return ArrayHelper::getValue(\app\models\Material::MATERIAL_MAPPING, $data->material_id);
                },
            ],
            'order',
            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update} {delete}',
            ],
        ],
    ]); ?>
</div>
