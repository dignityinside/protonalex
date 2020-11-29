<?php

namespace app\controllers;

use Yii;
use app\models\ad\Ad;
use app\models\ad\AdSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\UserPermissions;
use yii\web\UploadedFile;

/**
 * AdController implements the CRUD actions for Ad model.
 *
 * @author Alexander Schilling
 */
class AdController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['view', 'create', 'update', 'admin', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['view'],
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create', 'update', 'admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_AD],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::class,
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all ad models.
     * @return mixed
     */
    public function actionAdmin()
    {
        $searchModel = new AdSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('admin', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Creates a new ad model.
     * If creation is successful, the browser will be redirected to the 'admin' page.
     * @return mixed
     */
    public function actionCreate()
    {
        $model = new Ad();

        if ($model->load(Yii::$app->request->post())) {

            $model->banner_img_file = UploadedFile::getInstance($model, 'banner_img_file');

            if ($model->save()) {
                return $this->redirect(['admin']);
            }
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing ad model.
     * If update is successful, the browser will be redirected to the 'admin' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post())) {

            $model->banner_img_file = UploadedFile::getInstance($model, 'banner_img_file');

            if ($model->save()) {
                return $this->redirect(['admin']);
            }
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing ad model.
     * If deletion is successful, the browser will be redirected to the 'admin' page.
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
     * Display a single ad
     *
     * @param $slug
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {
        $model = Ad::find()->where([
            'status' => Ad::STATUS_PUBLIC,
            'slug' => $slug,
        ])->one();

        if (!$model || !empty($model->code)) {
            throw new NotFoundHttpException('Страница не найдена.');
        }

        $model->countHits('Ad');

        return $this->redirect($model->url);
    }

    /**
     * Finds the ad model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ad the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Ad::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
