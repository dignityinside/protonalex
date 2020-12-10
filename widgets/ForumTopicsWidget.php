<?php

namespace app\widgets;

use app\models\forum\Forum;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Forum topics widget
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class ForumTopicsWidget extends Widget
{

    public $count = 10;

    public $filter;

    /**
     * @inheritdoc
     */
    public function run()
    {

        if ($this->filter) {
            $topics = Forum::find()->active()->withCommentsCount()->populare($this->count)->all();
        } else {
            $topics = Forum::find()->active()->withCommentsCount()->recentTopics($this->count)->all();
        }

        if ($topics) {

            foreach ($topics as $topic) {

                if ($topic) {

                    $title = Html::a($topic['title'], Url::to(['forum/topic', 'id' => $topic->id], true));
                    $category = Html::a($topic['category']['name'], Url::to(['forum/topics/' . $topic['category']['slug']], true));
                    $username = Html::a($topic['user']['username'], Url::to(['forum/user/' . $topic['user']['username']], true));

                    $out = '';
                    $out .= '<div class="forum_topics_widget_item">';
                    $out .= '<div class="forum_topics_widget_item__title">' . $title . '</div>';
                    $out .= '<div class="forum_topics_widget_item__info">' . ' в разделе <i class="fa fa-folder"></i> ' . $category . ' от <i class="fa fa-user"></i>' . $username . ' <i class="fa fa-comments"></i> ответов: ' . $topic['commentsCount'] . '</div>';
                    $out .= '</div>';

                    if ($this->filter) {

                        if ((int)$topic['commentsCount'] !== 0) {
                            echo $out;
                        }

                    } else {
                        echo $out;
                    }

                }

            }

            if ($this->filter) {
                echo Html::a('Все популярные темы →', ['/forum/topics/new/hits']);
            } else {
                echo Html::a('Все новые темы →', ['/forum/topics/new']);
            }

        } else {
            echo 'Темы не найдены.';
        }
    }
}
