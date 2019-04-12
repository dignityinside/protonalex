<?php

use yii\helpers\Url;
use demi\comments\frontend\widgets\Comments;
use app\models\Deals;

/* @var $this yii\web\View */
/** @var $model app\models\Deals */

?>

<?php if ($model->allow_comments) : ?>

    <h3 class="comment-box__title">
        Оставьте комментарий!
    </h3>

    <?= Comments::widget(
        [
            'materialType' => Deals::MATERIAL_ID,
            'materialId' => $model->id,
            'options' => [
                'class' => 'comments list-unstyled',
            ],
            'nestedOptions' => [
                'class' => 'comments reply list-unstyled',
            ],
            'clientOptions' => [
                'deleteComfirmText' => 'Вы уверены что хотите удалить данный комментарий?',
                'updateButtonText' => 'Обновить',
                'cancelUpdateButtonText' => 'Отменить',
                'commentTextSelector' => '.comment-text > div',
            ],
            'maxNestedLevel' => 5,
            'materialViewUrl' => Url::to(['view', 'id' => $model->id]),
            'formConfig' => [
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
            ],
        ]
    ); ?>

<?php endif; ?>
