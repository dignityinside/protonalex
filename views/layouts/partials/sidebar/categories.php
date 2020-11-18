<?php

use app\models\category\Category;
use app\models\Material;
use yii\helpers\Html;

?>
<div class="widget">
    <div class="widget-title">
        <?= \Yii::t('app', 'sidebar_category'); ?>
    </div>
    <div class="widget-content">
        <div class="category-list">
            <?php
                $categories = Category::getCategoriesList(Material::MATERIAL_POST_ID);
            ?>
            <?php if (!empty($categories)) : ?>
                <?php foreach ($categories as $category) : ?>
                    <?php
                        $postsCount = count($category['posts'])
                    ?>
                    <?php if ($postsCount !== 0) : ?>
                        <div class="category-list__item">
                            <i class="fas fa-folder"></i>
                            <?= Html::a($category['name'], '/category/' . $category['slug']); ?>
                            <span>(<?= $postsCount; ?>)</span>
                        </div>
                    <?php endif; ?>
                <?php endforeach; ?>
            <?php endif; ?>
        </div>
    </div>
</div>
