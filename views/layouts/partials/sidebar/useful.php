<?php

use app\widgets\Links;

?>

<div class="widget">
    <div class="widget-title">
        <?= \Yii::t('app', 'sidebar_useful'); ?>
    </div>
    <div class="widget-content">
        <?php

            echo Links::widget([
                'items' => [
                    [
                        'label' => 'Yii Framework',
                        'url' => 'https://yiiframework.com',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Laravel',
                        'url' => 'https://laravel.com',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'PHP',
                        'url' => 'https://php.net',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'PHPStorm',
                        'url' => 'https://www.jetbrains.com/ru-ru/phpstorm/',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Github',
                        'url' => 'https://github.com',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Ubuntu-Linux',
                        'url' => 'https://ubuntu.com',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                ],
            ]);

        ?>
    </div>
</div>