<?php

use yii\helpers\Url;
use demi\comments\frontend\widgets\Comments;
use app\models\deals\Deals;

/* @var $this yii\web\View */
/** @var $model Deals */

?>

<?php if ($model->allow_comments) : ?>
    <h3 class="comment-box__title">
        <?= \Yii::t('app/comments', 'comment_box_title') ?>
    </h3>

    <?= Comments::widget(
        [
            'materialType' => \app\models\Material::MATERIAL_DEALS_ID,
            'materialId' => $model->id,
            'options' => [
                'class' => 'comments list-unstyled',
            ],
            'nestedOptions' => [
                'class' => 'comments reply list-unstyled',
            ],
            'clientOptions' => [
                'deleteComfirmText' => \Yii::t('app/comments', 'delete_confirm_text'),
                'updateButtonText' => \Yii::t('app/comments', 'update_button_text'),
                'cancelUpdateButtonText' => \Yii::t('app/comments', 'cancel_update_button_text'),
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
