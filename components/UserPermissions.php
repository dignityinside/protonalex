<?php

namespace app\components;

use app\models\Post;
use app\models\User;
use app\models\Video;

/**
 * User permissions contains various methods to check what user can do
 *
 * @author Alexander Schilling
 */
class UserPermissions
{

    const ADMIN_POST = 'adminPost';
    const ADMIN_USERS = 'adminUsers';
    const ADMIN_CATEGORY = 'adminCategory';
    const ADMIN_PLANET = 'adminPlanet';
    const ADMIN_VIDEO = 'adminVideo';

    /**
     * Checks if user can admin posts
     *
     * @return bool
     */
    public static function canAdminPost(): bool
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
    public static function canEditPost(Post $post): bool
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
    public static function canAdminUsers(): bool
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
     * Checks if user can admin planet
     *
     * @return bool
     */
    public static function canAdminPlanet(): bool
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_PLANET)) {
            return true;
        }

        return false;

    }

    /**
     * Checks if user can admin video
     *
     * @return bool
     */
    public static function canAdminVideo(): bool
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_VIDEO)) {
            return true;
        }

        return false;

    }

    /**
     * Checks if user can edit particular video
     *
     * @param Video $video
     *
     * @return bool
     */
    public static function canEditVideo(Video $video): bool
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (self::canAdminVideo()) {
            return true;
        }

        $currentUserID = \Yii::$app->user->getId();

        if ((int)$video->user_id === (int)$currentUserID) {
            return true;
        }

        return false;
    }

}
