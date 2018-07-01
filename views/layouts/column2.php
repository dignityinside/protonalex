<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="widget">
                <div class="widget-title">
                    Наше сообщество
                </div>
                <div class="widget-content">
                    <div class="widget-content-social">
                        <i class="fa fa-youtube"></i> <a href="https://youtube.com/dignityinside" target="_blank" rel="nofollow noopener">Канал на YouTube</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-vk"></i> <a href="https://vk.com/phpland" target="_blank" rel="nofollow noopener">Группа ВК</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-telegram"></i> <a href="https://t.me/phpland" target="_blank" rel="nofollow noopener">Канал в Telegram</a> | <a href="https://t.me/phpland_chat" target="_blank" rel="nofollow noopener">Чат</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-users"></i> <a href="https://gitter.im/phpland" target="_blank" rel="nofollow noopener">Чат в Gitter</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-twitter"></i> <a href="https://twitter.com/phplandorg" target="_blank" rel="nofollow noopener">Микроблог в Twitter</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-instagram"></i> <a href="https://instagram.com/phpland" target="_blank" rel="nofollow noopener">Истории в Instagram</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-link"></i> <a href="https://golos.io/@phpland" target="_blank" rel="nofollow noopener">Блог на Golos</a> | <a href="https://steemit.com/@dignityinside" target="_blank" rel="nofollow noopener">Steemit</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-github"></i> <a href="https://github.com/dignityinside" target="_blank" rel="nofollow noopener">Исходники на Github</a>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    Поддержите проект
                </div>
                <div class="widget-content">
                    <p>Яндекс-Деньги: <a href="https://money.yandex.ru/to/41001609245268" rel="nofollow" target="_blank">41001609245268</a></p>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    Рекомендую
                </div>
                <div class="widget-content">
                    <?= yii\helpers\Html::a(yii\helpers\Html::img('img/php-the-right-way.png'), 'http://www.phptherightway.com', ['rel'=>'nofollow', 'target'=>'_blank']) ?>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>