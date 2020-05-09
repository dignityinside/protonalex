<?php

use yii\helpers\Url;
use demi\comments\frontend\widgets\Comments;
use app\models\video\Video;

/* @var $this yii\web\View */

?>

<?php if ($model->allow_comments) : ?>
    <h3 class="comment-box__title">
        Оставьте комментарий!
    </h3>

    <?= Comments::widget(
        [
            'materialType' => \app\models\Material::MATERIAL_VIDEO_ID,
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
            'materialViewUrl' => Url::to(['watch', 'id' => $model->id]),
            'formConfig' => [
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
            ],
        ]
    ); ?>

<?php endif; ?>
