<?php

    $adsVisibility = $model->author->ads_visibility;

    $show = false;

    if ($adsVisibility === app\models\User::VISIBILITY_REGISTER_USER_ONLY
        && Yii::$app->user->isGuest || $adsVisibility === app\models\User::VISIBILITY_ALL_USERS) {
        $show = true;
    }

?>

<?php if (isset($model->author->aads_com_id) && $show) : ?>

    <hr>

    <div class="author_support_hint">
        У вас включён блокировщик рекламы (Adblocker, Adblocker Plus, uBlock).<br>
        Если вы хотите поддержать автора данного поста, пожалуйста выключите его!
    </div>

    <iframe data-aa='956289' src='//ad.a-ads.com/<?= $model->author->aads_com_id; ?>?size=120x60' class='author_support'></iframe>

    <hr>

<?php endif; ?>
