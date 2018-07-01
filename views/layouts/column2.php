<?php $this->beginContent('@app/views/layouts/main.php'); ?>

    <div class="row">
        <div class="col-md-3">
            <div class="widget">
                <div class="widget-title">
                    Наше сообщество
                </div>
                <div class="widget-content">
                    <div class="widget-content-social">
                        <i class="fa fa-vk"></i> <a href="https://vk.com/roolandorg" target="_blank" rel="nofollow noopener">Группа ВК</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-telegram"></i> <a href="https://t.me/roolandorg" target="_blank" rel="nofollow noopener">Канал в Telegram</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-twitter"></i> <a href="https://twitter.com/roolandorg" target="_blank" rel="nofollow noopener">Микроблог в Twitter</a>
                    </div>
                    <div class="widget-content-social">
                        <i class="fa fa-instagram"></i> <a href="https://instagram.com/roolandorg" target="_blank" rel="nofollow noopener">Истории в Instagram</a>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-9">
            <?= $content; ?>
        </div>
    </div>

<?php $this->endContent(); ?>
