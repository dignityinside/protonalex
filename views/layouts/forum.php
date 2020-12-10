<?php

use app\models\ad\Ad;
use app\models\category\Category;
use app\models\Material;

$this->beginContent('@app/views/layouts/main.php'); ?>

<div class="row">
    <div class="col-md-3">
        <div class="widget">
            <div class="widget-title">
                Популярные темы
            </div>
            <div class="widget-content">
                <?= app\widgets\ForumTopicsWidget::widget(['count' => 5, 'filter' => 'new']); ?>
            </div>
        </div>
        <div class="widget">
            <div class="widget-title">
                Новые темы
            </div>
            <div class="widget-content">
                <?= app\widgets\ForumTopicsWidget::widget(['count' => 5]); ?>
            </div>
        </div>
        <div class="widget">
            <div class="widget-title">
                Разделы
            </div>
            <div class="widget-content">
                <?= app\widgets\ForumCategoriesWidget::widget(); ?>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <?= $content; ?>
    </div>
    <div class="col-md-3">
        <?= app\widgets\Ad::widget(['slot' => Ad::SLOT_SIDEBAR]); ?>
    </div>
</div>

<?php $this->endContent(); ?>
