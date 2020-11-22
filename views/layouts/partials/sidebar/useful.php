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
                        'label' => 'g2a',
                        'url' => 'https://www.g2a.com/r/gr-5dd7b53b1faa0',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Steambuy',
                        'url' => 'https://steambuy.com/partner/182122',
                        'rel' => 'nofollow',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Ubuntu-Linux',
                        'url' => 'https://ubuntu.com',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'Linux Mint',
                        'url' => 'https://linuxmint.com',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                    [
                        'label' => 'elementaryOS',
                        'url' => 'https://elementary.io/',
                        'rel' => 'nofollow noopener',
                        'target' => '_blank'
                    ],
                ],
            ]);

        ?>
    </div>
</div>