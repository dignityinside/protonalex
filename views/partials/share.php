<?php

use app\widgets\Sharpay;

?>

<div class="share">
    <?= \Yii::t('app', 'share_friends') ?><br>
    <?= Sharpay::widget(); ?>
</div>
