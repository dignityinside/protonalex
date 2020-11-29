<?php

namespace app\components;

use app\models\post\Post;
use app\models\User;

/**
 * User permissions contains various methods to check what user can do
 *
 * @author Alexander Schilling
 */
class UserPermissions
{

    public const ADMIN_POST = 'adminPost';
    public const ADMIN_USERS = 'adminUsers';
    public const ADMIN_CATEGORY = 'adminCategory';
    public const ADMIN_AD = 'adminAd';

    /**
     * Checks if user can admin posts
     *
     * @return bool
     */
    public static function canAdminPost(): bool
    {

        if (\Yii::$app->user->can(self::ADMIN_POST)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if user can admin other users
     *
     * @return bool
     */
    public static function canAdminUsers(): bool
    {

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
    public static function canEditUser(User $user): bool
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

    /**
     * Checks if user can admin category
     *
     * @return bool
     */
    public static function canAdminCategory(): bool
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_CATEGORY)) {
            return true;
        }

        return false;
    }

    /**
     * Checks if user can admin ad
     *
     * @return bool
     */
    public static function canAdminAd(): bool
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_AD)) {
            return true;
        }

        return false;
    }
}
