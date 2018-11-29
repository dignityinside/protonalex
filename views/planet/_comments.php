<?php

use yii\helpers\Html;
use yii\helpers\Url;

?>

<h3 class="comment-box__title">
    Оставьте комментарий!
</h3>

<p>Если у Вас остались какие-либо вопросы, либо у Вас есть желание высказаться по поводу этой статьи, то Вы можете
    оставить свой комментарий на <?= Html::a('сайте автора статьи', $model->guid, ['target' => '_blank', 'rel' => 'nofollow']) ?> или написать его здесь:</p>

<?= \demi\comments\frontend\widgets\Comments::widget(
    [
        'materialType'    => 2,
        'materialId'      => $model->id,
        'options'         => [
            'class' => 'comments list-unstyled',
        ],
        'nestedOptions'   => [
            'class' => 'comments reply list-unstyled',
        ],
        'clientOptions'   => [
            'deleteComfirmText'      => 'Вы уверены что хотите удалить данный комментарий?',
            'updateButtonText'       => 'Обновить',
            'cancelUpdateButtonText' => 'Отменить',
            'commentTextSelector' => '.comment-text > div',
        ],
        'maxNestedLevel'  => 5,
        'materialViewUrl' => Url::to(['view', 'id' => $model->id]), // @todo: link not working
        'formConfig'      => [
            'enableClientValidation' => true,
            'enableAjaxValidation'   => false,
        ],
    ]
); ?>
