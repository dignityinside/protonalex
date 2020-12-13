<?php

namespace app\widgets;


use app\models\Material;
use app\models\Comment;
use yii\base\Widget;
use yii\helpers\Html;
use yii\helpers\Url;

/**
 * Forum comments widget
 *
 * @package app\widgets
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class ForumCommentsWidget extends Widget
{

    public $count = 10;

    public $filter;

    /**
     * @inheritdoc
     */
    public function run()
    {

        $comments = Comment::find()
            ->andWhere(['material_type' => Material::MATERIAL_FORUM_ID])
            ->orderBy('created_at DESC')
            ->limit($this->count)
            ->all();

        if ($comments) {

            foreach ($comments as $comment) {

                if ($comment['user_id'] !== null) {
                    $username = Html::a($comment->user->username, Url::to(['forum/user/' . $comment->user->username], true));
                } else {
                    $username = $comment->user_name;
                }

                $text = mb_substr($comment['text'], 0, 80);

                if (strlen($text) >= 80) {
                    $text .= '...';
                }

                $text = Html::a($text, '/forum/topic/' .$comment->topics->id . '#comment-' . $comment->id);

                $out = '';
                $out .= '<div class="forum_comments_widget_item">';
                $out .= '<div class="forum_comments_widget_item__title">' . $text . '</div>';
                $out .= '<div class="forum_comments_widget_item__info">';
                $out .= ' от <i class="fa fa-user"></i> ' . $username;
                $out .= ' в теме: "' . $comment->topics->title . '"';
                $out .= '</div>';
                $out .= '</div>';

                echo $out;

            }

        } else {
            echo 'Новых ответов нет.';
        }
    }
}
