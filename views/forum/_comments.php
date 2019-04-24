<?php

use yii\helpers\Url;
use demi\comments\frontend\widgets\Comments;
use app\models\Forum;

/* @var $this yii\web\View */
/** @var $model app\models\Forum */

?>

<?php if ($model->allow_comments) : ?>

    <?= Comments::widget(
        [
            'materialType' => Forum::MATERIAL_ID,
            'materialId' => $model->id,
            'options' => [
                'class' => 'comments list-unstyled',
            ],
            'nestedOptions' => [
                'class' => 'comments reply list-unstyled',
            ],
            'clientOptions' => [
                'deleteComfirmText' => 'Вы уверены что хотите удалить данный ответ?',
                'updateButtonText' => 'Обновить',
                'cancelUpdateButtonText' => 'Отменить',
                'commentTextSelector' => '.comment-text > div',
            ],
            'maxNestedLevel' => 5,
            'materialViewUrl' => Url::to(['topic', 'id' => $model->id]),
            'formConfig' => [
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
            ],
        ]
    ); ?>

<?php endif; ?>
