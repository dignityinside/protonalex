<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="widget">
                <div class="widget-title">
                    Сообщество
                </div>
                <div class="widget-content">
                    <div class="widget-content__social-icons">
                        <a href="https://t.me/roolandorg" target="_blank" rel="nofollow" title="Telegram канал"><i class="fa fa-telegram"></i></a>
                        <a href="https://vk.com/roolandorg" target="_blank" rel="nofollow" title="Группа ВК"><i class="fa fa-vk"></i></a>
                        <a href="https://mastodon.social/@roolandorg" rel="me nofollow" target="_blank"><i class="fab fa-mastodon"></i></a>
                        <a href="https://instagram.com/roolandorg" target="_blank" rel="nofollow" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://github.com/rooland" target="_blank" rel="nofollow" title="Исходный код на Github"><i class="fa fa-github"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    Планета
                </div>
                <div class="widget-content">
                    <p>Наша планета собирает интересные статьи из различных источников и объединяет их в одну ленту. Которую можно читать на нашем сайте.</p>
                    <p><?= \yii\helpers\Html::a('Подробнее »', '/planet')?></p>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>
