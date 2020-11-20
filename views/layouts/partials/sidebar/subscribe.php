<div class="widget">
    <div class="widget-title">
        <?= \Yii::t('app', 'sidebar_subscribe'); ?>
    </div>
    <div class="widget-content">
        <p><?= \Yii::t('app', 'subscribe_text') ?></p>
        <div class="ml-form-embed"
             data-account="<?= \Yii::$app->params['subscribe']['dataAccount']; ?>"
             data-form="<?= \Yii::$app->params['subscribe']['dataFormSidebar']; ?>">
        </div>
    </div>
</div>