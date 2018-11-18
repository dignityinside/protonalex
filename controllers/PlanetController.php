<?php

namespace app\controllers;

use app\components\UserPermissions;
use app\models\Planet;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * PlanetController implements the CRUD actions for Planet model.
 *
 * @author Alexander Schilling
 */
class PlanetController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['admin', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_PLANET],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists of all posts from planet (admin view)
     *
     * @return mixed
     */
    public function actionAdmin()
    {
        $dataProvider = new ActiveDataProvider(
            [
                'query' => Planet::find()->orderBy('pub_date DESC'),
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );

        return $this->render('admin', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Lists all post from planet
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $query = Planet::find();

        $dataProvider = new ActiveDataProvider(
            [
                'query' => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );

        $query->andFilterWhere(['status_id' => Planet::STATUS_PUBLIC])->orderBy('pub_date DESC');

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);

    }

    /**
     * Deletes an existing Planet model.
     *
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Finds the Planet model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param integer $id
     * @return Planet the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Planet::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}