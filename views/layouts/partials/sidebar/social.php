<?php if (!empty(\Yii::$app->params['social'])) : ?>
    <div class="widget">
        <div class="widget-title">
            <?= \Yii::t('app/blog', 'social_networking'); ?>
        </div>
        <div class="widget-content">
            <div class="social_buttons">
                <?php foreach (\Yii::$app->params['social'] as $key => $value) : ?>
                    <a href="<?= $value['url'] ?>" target="_blank" rel="nofollow noopener"
                       style="text-decoration: none" title="<?= $value['title'] ?>">
                        <div class="social_buttons__item" style="background: <?= $value['bgColor'] ?>">
                            <i class="<?= $value['faClass']; ?>"></i>
                        </div>
                    </a>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
<?php endif; ?>