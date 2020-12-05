<?php

    $subscribeId = \Yii::$app->params['subscribe']['id'];

?>

<div class="subscribe">

    <p><?= \Yii::t('app', 'subscribe_text') ?></p>

    <form action="https://feedburner.google.com/fb/a/mailverify" method="post" target="popupwindow" onsubmit="window.open('https://feedburner.google.com/fb/a/mailverify?uri=<?= $subscribeId; ?>', 'popupwindow', 'scrollbars=yes,width=550,height=520');return true">

        <div class="form-group">
            <input type="hidden" value="<?= $subscribeId; ?>" name="uri"/>
            <input type="hidden" name="loc" value="ru_RU"/>
            <input type="text" name="email" placeholder="E-Mail" class="form-control"/>
        </div>

        <div class="form-group">
            <input type="submit" value="Подписаться" class="btn btn-danger" />
        </div>

        <div class="form-group">
            <a href="http://feeds.feedburner.com/<?= $subscribeId; ?>" target="_blank" rel="nofollow"
               class="btn btn-link" style="text-decoration: none">
                <i class="fa fa-rss"></i> RSS
            </a>
        </div>

    </form>

</div>
