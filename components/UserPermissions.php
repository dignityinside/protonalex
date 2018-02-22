<?php

namespace app\components;

use app\models\Post;
use app\models\User;

/**
 * User permissions contains various methods to check what user can do
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class UserPermissions
{

    const ADMIN_POST = 'adminPost';
    const ADMIN_USERS = 'adminUsers';

    /**
     * Checks if user can admin posts
     *
     * @return bool
     */
    public static function canAdminPost()
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_POST)) {
            return true;
        }

        return false;

    }

    /**
     * Checks if user can edit particular posts
     *
     * @param Post $post
     *
     * @return bool
     */
    public static function canEditPost(Post $post)
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (self::canAdminPost()) {
            return true;
        }

        $currentUserID = \Yii::$app->user->getId();

        if ((int)$post->user_id === (int)$currentUserID) {
            return true;
        }

        return false;
    }

    /**
     * Checks if user can admin other users
     *
     * @return bool
     */
    public static function canAdminUsers()
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_USERS)) {
            return true;
        }

        return false;

    }

    /**
     * Checks if user can edit profile
     *
     * @param User $user
     *
     * @return bool
     */
    public static function canEditUser(User $user)
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        $currentUserID = \Yii::$app->user->getId();

        if ((int)$user->id === $currentUserID) {
            return true;
        }

        if (self::canAdminUsers()) {
            return true;
        }

        return false;

    }

}
