<?php

    $show = Yii::$app->user->isGuest ? true : false;
    $aadsComId = \Yii::$app->params['aads_com_id'] ?? '';

?>

<?php if (!empty($aadsComId) && $show) : ?>

    <hr>

    <div class="author_support_hint">
        У вас включён блокировщик рекламы (Adblocker, Adblocker Plus, uBlock).<br>
        Если вы хотите поддержать наше сообщество, пожалуйста выключите его!
    </div>

    <iframe data-aa='<?= $aadsComId ?>' src='//ad.a-ads.com/<?= $aadsComId; ?>?size=120x60' class='author_support'></iframe>

    <hr>

<?php endif; ?>
