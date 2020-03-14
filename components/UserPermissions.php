<?php

namespace app\components;

use app\models\Post;
use app\models\User;
use app\models\Video;
use app\models\Deals;
use app\models\Forum;

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
    const ADMIN_VIDEO = 'adminVideo';
    const ADMIN_DEALS = 'adminDeals';
    const ADMIN_FORUM = 'adminForum';

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

    /**
     * Checks if user can admin deals
     *
     * @return bool
     */
    public static function canAdminDeals(): bool
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_DEALS)) {
            return true;
        }

        return false;

    }

    /**
     * Checks if user can edit particular deal
     *
     * @param Deals $deals
     *
     * @return bool
     */
    public static function canEditDeals(Deals $deals): bool
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (self::canAdminDeals()) {
            return true;
        }

        $currentUserID = \Yii::$app->user->getId();

        if ((int)$deals->user_id === (int)$currentUserID) {
            return true;
        }

        return false;
    }

    /**
     * Checks if user can admin forum
     *
     * @return bool
     */
    public static function canAdminForum(): bool
    {

        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (\Yii::$app->user->can(self::ADMIN_FORUM)) {
            return true;
        }

        return false;

    }

    /**
     * Checks if user can edit particular forum
     *
     * @param Forum $forum
     *
     * @return bool
     */
    public static function canEditForum(Forum $forum): bool
    {
        if (\Yii::$app->user->isGuest) {
            return false;
        }

        if (self::canAdminForum()) {
            return true;
        }

        $currentUserID = \Yii::$app->user->getId();

        if ((int)$forum->user_id === (int)$currentUserID) {
            return true;
        }

        return false;
    }

}
