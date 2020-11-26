<?php

use app\widgets\Links;

?>
<div class="widget">
    <div class="widget-title">
        <?= \Yii::t('app', 'sidebar_friends'); ?>
    </div>
    <div class="widget-content">
        <?php

            echo Links::widget([
                'items' => [
                    [
                        'label' => 'protonduck',
                        'url' => 'https://protonduck.com',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Александр Макаров',
                        'url' => 'https://rmcreative.ru',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Михаил Шакин',
                        'url' => 'http://shakin.ru',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Иван Орлов',
                        'url' => 'https://orlov.io/ru',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                ],
            ]);

        ?>
    </div>
</div>