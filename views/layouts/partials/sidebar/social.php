<?php

use app\widgets\Links;

$social = \Yii::$app->params['social'];

?>

<div class="widget">
    <div class="widget-title">
        <?= \Yii::t('app/blog', 'social_networking'); ?>
    </div>
    <div class="widget-content">
        <?php

            echo Links::widget([
                'items' => [
                    [
                        'label' => 'Mastodon',
                        'url' => 'https://mastodon.social/@' . $social['mastodon'],
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                ],
            ]);

        ?>
    </div>
</div>