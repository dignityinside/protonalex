<?php

use yii\web\View;
use yii\helpers\Html;
use demi\comments\common\models\Comment;

/* @var $this View */
/* @var $comment Comment */

// Comment ID
$cid = $comment->primaryKey;

// Comment app component
$component = $comment->getComponent();

// Photo
$userPhoto = $comment->getUserPhoto();

// Profile url
$userProfileUrl = $comment->getUserProfileUrl();

// User name
$username = $comment->getUsername();

if (empty($username)) {
    $username = \Yii::t('app', 'user_anonym');
}

$profileLink = $userProfileUrl ? Html::a($username, $userProfileUrl, ['class' => 'p-author h-card']) : $username;

?>
<div class="comment h-entry<?php if (empty($userPhoto)) {
    echo ' no-user-photo';
} ?>">
    <?php if (!empty($userPhoto)): ?>
        <div class="comment-user-photo">
            <?php
            // User photo image
            $image = Html::img($userPhoto, ['alt' => Html::decode($username)]);
            // Show link+image or simple image
            echo $userProfileUrl !== null ? Html::a($image, $userProfileUrl) : $image;
            ?>
        </div>
    <?php endif ?>
    <div class="comment-body">
        <div class="comment-permament-link">
            <?= Html::a('#' . $cid, '#comment-' . $cid, ['class' => 'u-url']) ?>
        </div>
        <div class="comment-username">
            <?= $profileLink; ?> <?= \Yii::t('app/comments', 'user_wrote'); ?>:
        </div>
        <div class="comment-text e-content">
            <div><?= $comment->getPreparedText() ?></div>
        </div>
        <div class="comment-bottom">
            <div class="comment-actions">
                <i class="fa fa-reply"></i> <a class="reply-button" data-comment-id="<?= $cid ?>" href="#">
                    <?= \Yii::t('app/comments', 'button_reply'); ?>
                </a>

                <?php if ($comment->canUpdate()): ?>
                    <i class="fa fa-edit"></i> <?= Html::a(
                        \Yii::t('app', 'button_edit'),
                        ['/comment/default/update', 'id' => $cid],
                        ['class' => 'update-button']
                    ) ?>
                <?php endif ?>

                <?php if ($comment->canDelete()): ?>
                    <i class="fa fa-remove"></i> <?= Html::a(
                        \Yii::t('app', 'button_delete'),
                        ['/comment/default/delete', 'id' => $cid],
                        ['class' => 'delete-button']
                    ) ?>
                <?php endif ?>

            </div>
            <time class="dt-published" datetime="<?= $comment->created_at ?>"><?= $comment->fDate ?></time>
        </div>
    </div>
</div>