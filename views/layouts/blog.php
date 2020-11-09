<?php $this->beginContent('@app/views/layouts/main.php'); ?>

<div class="row">
    <div class="col-md-9">
        <?= $content; ?>
    </div>
    <div class="col-md-3">
        <div class="widget">
            <div class="widget-title">
                <?= \Yii::t('app/blog', 'social_networking'); ?>
            </div>
            <div class="widget-content">
                <div class="widget-content__social-icons">
                    <?php
                        $social = \Yii::$app->params['social'];
                    ?>
                    <p>
                        <a href="https://instagram.com/<?= $social['instagram'] ?>" target="_blank" rel="nofollow" title="Instagram">
                            <i class="fab fa-instagram"></i>
                        </a>
                        <span>
                            <a href="https://instagram.com/<?= $social['instagram'] ?>" target="_blank" rel="nofollow" title="Instagram">
                                Instagram
                            </a>
                        </span>
                    </p>
                    <p>
                        <a href="https://mastodon.social/@<?= $social['mastodon'] ?>" target="_blank" rel="nofollow" title="Mastodon">
                            <i class="fab fa-mastodon"></i>
                        </a>
                        <span>
                            <a href="https://mastodon.social/@<?= $social['mastodon'] ?>" target="_blank" rel="nofollow" title="Mastodon">
                                Mastodon
                            </a>
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <?php if (\Yii::$app->user->identity === null) : ?>
            <div class="widget">
                <div class="widget-title">Реклама</div>
                <div class="widget-content">
                    <?= $this->render('partials/ad') ?>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<?php $this->endContent(); ?>
