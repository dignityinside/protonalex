<?php

namespace app\controllers;

use Yii;
use app\models\User;
use app\components\UserPermissions;
use yii\authclient\Collection;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * UserController implements the CRUD actions for User model.
 *
 * @package app\controllers
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class UserController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['update'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['view', 'update'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['admin', 'create', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_USERS],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['post'],
                ],
            ],
        ];

    }

    /**
     * Lists all User models.
     *
     * @return mixed
     */
    public function actionAdmin()
    {

        $dataProvider = new ActiveDataProvider(
            [
                'query' => User::find(),
            ]
        );

        return $this->render(
            'admin', [
            'dataProvider' => $dataProvider,
        ]
        );

    }

    /**
     * Displays user profile
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {

        /** @var User $user */
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('Пользователь не найден.');
        }

        $authClients = [];

        if (Yii::$app->user->id == $user->id) {

            // get clients user isn't connected with yet
            $auths = $user->auths;

            /** @var Collection $clientCollection */
            $clientCollection = Yii::$app->authClientCollection;

            $authClients = $clientCollection->getClients();

            foreach ($auths as $auth) {
                unset($authClients[$auth->source]);
            }

        }

        return $this->render(
            'view', [
            'model'       => $user,
            'authClients' => $authClients,
        ]
        );

    }

    /**
     * Updates an existing User model.
     *
     * If update is successful, the browser will be redirected to the 'view' page.
     *
     * @param integer $id
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     *
     * @return mixed
     */
    public function actionUpdate($id)
    {

        $model = $this->findModel($id);

        if (!UserPermissions::canEditUser($model)) {
            throw new ForbiddenHttpException('Вы не можете редактировать этот профиль.');
        }

        if (UserPermissions::canAdminUsers()) {
            $model->scenario = User::SCENARIO_ADMIN;
        } else {
            $model->scenario = User::SCENARIO_UPDATE;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render(
            'update', [
            'model' => $model,
        ]
        );

    }

    /**
     * Deletes an existing User model.
     *
     * If deletion is successful, the browser will be redirected to the 'index' page.
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {

        $model = $this->findModel($id);
        $model->status = User::STATUS_DELETED;
        $model->save();

        return $this->redirect(['admin']);

    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     *
     * @return User the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');

    }

}
