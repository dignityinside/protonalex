<?php

namespace app\commands;

use app\components\UserPermissions;
use app\models\User;
use Yii;
use yii\base\InvalidArgumentException;
use yii\console\Controller;
use yii\console\ExitCode;

/**
 * Class RbacController
 *
 * @package app\commands
 *
 * @author Alexander Schilling
 */
class RbacController extends Controller
{

    /**
     * @return int
     *
     * @throws \Exception
     * @throws \yii\base\Exception
     */
    public function actionInit()
    {

        if (!$this->confirm(\Yii::t('app', 'rbac_recreate_permissions'))) {
            return ExitCode::OK;
        }

        $auth = Yii::$app->authManager;
        $auth->removeAll();

        $adminPost = $auth->createPermission(UserPermissions::ADMIN_POST);
        $adminPost->description = \Yii::t('app', 'rbac_administrate_posts');
        $auth->add($adminPost);

        $adminUsers = $auth->createPermission(UserPermissions::ADMIN_USERS);
        $adminUsers->description = \Yii::t('app', 'rbac_administrate_users');
        $auth->add($adminUsers);

        $adminCategory = $auth->createPermission(UserPermissions::ADMIN_CATEGORY);
        $adminCategory->description = \Yii::t('app', 'rbac_administrate_categories');
        $auth->add($adminCategory);

        $admin = $auth->createRole('admin');
        $admin->description = 'Administrator';

        $auth->add($admin);
        $auth->addChild($admin, $adminUsers);
        $auth->addChild($admin, $adminPost);
        $auth->addChild($admin, $adminCategory);

        return ExitCode::OK;

    }

    /**
     * @param $role
     * @param $username
     *
     * @throws \Exception
     */
    public function actionAssign($role, $username)
    {

        $user = User::find()->where(['username' => $username])->one();

        if (!$user) {
            throw new InvalidArgumentException(\Yii::t('app', 'no_user_{username}', [
                'username' => $username,
            ]));
        }

        $auth = Yii::$app->authManager;

        $roleObject = $auth->getRole($role);

        if (!$roleObject) {
            throw new InvalidArgumentException(\Yii::t('app', 'no_role_{role}', [
                'role' => $role,
            ]));
        }

        $auth->assign($roleObject, $user->id);
    }
}
