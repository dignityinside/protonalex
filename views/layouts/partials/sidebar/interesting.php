<?php

use app\widgets\Links;

?>

<div class="widget">
    <div class="widget-title">
        <?= \Yii::t('app', 'sidebar_interesting'); ?>
    </div>
    <div class="widget-content">
        <?php

            echo Links::widget([
                'items' => [
                    [
                        'label' => 'Хакер',
                        'url' => 'https://xakep.ru/',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Хабр',
                        'url' => 'https://habr.com/ru/',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                ],
            ]);

        ?>
    </div>
</div>