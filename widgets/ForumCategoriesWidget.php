<?php

namespace app\widgets;

use app\models\category\Category;
use app\models\Material;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Forum categories widget
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class ForumCategoriesWidget extends Widget
{
    /**
     * @inheritdoc
     */
    public function run()
    {
        $categories = Category::find()
            ->andWhere(['material_id' => Material::MATERIAL_FORUM_ID])
            ->orderBy('order')
            ->with('forums')
            ->asArray()
            ->all();

        if (!empty($categories)) {

            echo '<div class="category-list">';

            foreach ($categories as $category) {

                $topicsCount = count($category['forums']);

                if ($topicsCount !== 0) {

                    $title = Html::a($category['name'], Url::to(['forum/topics/' . $category['slug']], true));

                    echo '<div class="category-list__item">';
                    echo '<div class="forum_categories_widget_item__title">';
                    echo '<i class="fas fa-folder"></i>' . $title . ' <span>(' . count($category['forums']) . ')</span>';
                    echo '</div>';
                    echo '</div>';

                }
            }

            echo '</div>';

        } else {
            echo 'Нет категорий.';
        }
    }
}
