<h3 class="comment-box__title">Оставьте комментарий!</h3>

<p>Если у Вас остались какие-либо вопросы, либо у Вас есть желание высказаться по поводу этой статьи, то Вы можете
    оставить свой комментарий:</p>

<?php

use yii\helpers\Url;

echo \demi\comments\frontend\widgets\Comments::widget(
    [
        // From config file "types" array key (1 => 'Publication')
        'materialType'    => 1,
        // You Publication model unique identifier
        // If you don't have this value simply type your unique key eg: "123",
        // for clarify code you can make const ABOUT_PAGE_COMMENTS_ID = 123
        'materialId'      => $model->id,

        // RECOMENDED FOR FIRST RUN COMMENTED OPTIONS BELOW AND CUSTOMIZED IT AFTER TESTING
        // HTML-options for main comments ul-tag
        'options'         => [
            'class' => 'comments list-unstyled',
        ],
        // HTML-options for nested comments ul-tag
        'nestedOptions'   => [
            'class' => 'comments reply list-unstyled',
        ],
        // jQuery-plugin options, see all options: vendor/demi/comments/frontend/widgets/assets/js/comments.js:55
        'clientOptions'   => [
            'deleteComfirmText'      => 'Вы уверены что хотите удалить данный комментарий?',
            'updateButtonText'       => 'Обновить',
            'cancelUpdateButtonText' => 'Отменить',
            'commentTextSelector' => '.comment-text > div',
        ],
        // Maximum nested level. If level reached - nested comments will be outputted without ul-tag.
        'maxNestedLevel'  => 5,
        // Url for permalink (without '#')
        'materialViewUrl' => Url::to(['view', 'id' => $model->id]),
        // ActiveForm configuration
        'formConfig'      => [
            'enableClientValidation' => true,
            'enableAjaxValidation'   => false,
        ],
    ]
); ?>

