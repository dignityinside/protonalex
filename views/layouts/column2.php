<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <div class="row">
        <div class="col-md-9">
            <?= $content; ?>
        </div>
        <div class="col-md-3">
            <div class="widget">
                <div class="widget-title">
                    Соц-сети
                </div>
                <div class="widget-content">
                    <div class="widget-content__social-icons">
                        <a href="https://instagram.com/roolandorg" target="_blank" rel="nofollow" title="Instagram"><i class="fab fa-instagram"></i></a>
                        <a href="https://t.me/roolandorg" target="_blank" rel="nofollow" title="Telegram канал"><i class="fa fa-telegram"></i></a>
                        <a href="https://vk.com/roolandorg" target="_blank" rel="nofollow" title="Группа ВК"><i class="fa fa-vk"></i></a>
                        <a href="https://mastodonsocial.ru/@roolandorg" rel="me nofollow" target="_blank"><i class="fab fa-mastodon"></i></a>
                        <a href="https://twitter.com/roolandorg" rel="nofollow" target="_blank"><i class="fab fa-twitter"></i></a>
                    </div>
                </div>
            </div>
            <div class="widget">
                <div class="widget-title">
                    Сделки
                </div>
                <div class="widget-content">
                    <p>Самые горячие и выгодные сделки, акции и скидки на твои любимые игры, книги, видео курсы, программы и многое другое.</p>
                    <p><?= \yii\helpers\Html::a('Подробнее »', '/deals')?></p>
                </div>
            </div>
        </div>
    </div>

<?php $this->endContent(); ?>
