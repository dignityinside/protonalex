<?php

use yii\helpers\Html;
use demi\comments\common\models\Comment;

return [
    "userModelClass"     => 'app\models\User',
    'class'              => 'demi\comments\common\components\Comment',
    // Material types list
    'types'              => [
        1 => 'Post',
    ],
    // Anonymous function to get user display name
    'getUsername'        => function (Comment $comment) {
        // By default anon comment user name
        $name = $comment->user_name;
        // If comment author is registered user
        if ($comment->user) {
            // $comment->user by default relation to your \common\models\User
            $name = $comment->user->username;
        }

        return Html::encode($name);
    },
    // Anonymous function to get user profile view url
    'getUserProfileUrl'  => function (Comment $comment) {
        // You can check if app is backend and return url to user profile edit
        return $comment->isAnonymous ? null : ['/user/view', 'id' => $comment->user_id];
    },
    // Anonymous function to get user photo image src
    'getUserPhoto'       => function (Comment $comment) {

        if ($comment->isAnonymous) {
            return Yii::$app->request->baseUrl . '/img/no-avatar.jpg';
        }

        // $comment->user by default relation to your \common\models\User
        // return $comment->user->avatar_url;
        return Yii::$app->request->baseUrl . '/img/no-avatar.jpg';

    },
    // Anonymous function to get comment text
    // By default: nl2br(Html::encode($comment->text))
    'getCommentText'     => function (Comment $comment) {
        // @todo add markdown support
        return nl2br($comment->text);
    },
    // Anonymous function to get comment create time
    // By default: Yii::$app->formatter->asDatetime($comment->created_at)
    'getCommentDate'     => function (Comment $comment) {
        return Yii::$app->formatter->asDatetime($comment->created_at);
    },
    // Anonymous function to get comment permalink.
    // By default: '#comment-' . $comment->id
    'getPermalink'       => function (Comment $comment) {

        $url = '#comment-' . $comment->id;

        // If you have "admin" subdomain, you can specify absolute url path for use "goToComment" from admin page
        if ($comment->material_type == 1) {
            // http://site.com/publication/3221#comment-4
            $url = 'http://phpland.org/post/' . $comment->material_id . $url;
        }

        return $url;

    },
    'canDelete'          => function (Comment $comment) {
        // Only admin can delete comment
        return Yii::$app->has('user') && Yii::$app->user->can('admin');
    },
    'canUpdate'          => function (Comment $comment) {
        if (Yii::$app->has('user') && Yii::$app->user->can('admin')) {
            // Admin can edit any comment
            return true;
        } elseif ($comment->isAnonymous) {
            // Any non-admin user cannot edit any anon comment
            return false;
        }

        // Comment can be edited by author at anytime
        // todo You can calc $comment->created_at and eg. allow comment editing by author within X hours after posting
        return Yii::$app->has('user') && Yii::$app->user->id == $comment->user_id;
    },
    // Anonymous function to set siteKey for reCAPTCHA widget
    // @see https://www.google.com/recaptcha/admin
    // You can set string value instead function
    'reCaptchaSiteKey'   => function () {
        return Yii::$app->params['reCAPTCHA.siteKey'];
    },
    'reCaptchaSecretKey' => function () {
        return Yii::$app->params['reCAPTCHA.secretKey'];
    },

    // Path to view file for render comments list (<ul> and <li> tags + nested)
    'listView'           => '@app/views/comment/comments',

    // Path to view file for render each comment item (inside the <li> tag)
    'itemView'           => '@app/views/comment/_comment',

    // Path to view file for render new comment form
    'formView'           => '@app/views/comment/form',

];
