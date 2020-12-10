<?php

use yii\helpers\Url;
use demi\comments\frontend\widgets\Comments;
use app\models\forum\Forum;

/* @var $this yii\web\View */
/** @var $model Forum */

?>

<?php if ($model->allow_comments) : ?>
    <?= Comments::widget(
        [
            'materialType' => \app\models\Material::MATERIAL_FORUM_ID,
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
            'materialViewUrl' => Url::to(['topic', 'id' => $model->id]),
            'formConfig' => [
                'enableClientValidation' => true,
                'enableAjaxValidation' => false,
            ],
        ]
    ); ?>

<?php endif;