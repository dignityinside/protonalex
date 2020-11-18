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
                        'label' => 'Lifehacker',
                        'url' => 'https://lifehacker.ru',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Pepper',
                        'url' => 'https://www.pepper.ru',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Хакер',
                        'url' => 'https://xakep.ru/',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                ],
            ]);

        ?>
    </div>
</div>