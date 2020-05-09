<?php

namespace app\controllers;

use app\components\UserPermissions;
use app\models\category\Category;
use app\models\Material;
use app\models\User;
use app\models\video\Video;
use app\models\video\VideoSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * VideoController implements the CRUD actions for Video model.
 *
 * @author Alexander Schilling
 */
class VideoController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'watch', 'category', 'create', 'update', 'admin', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'category', 'watch'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create', 'update', 'admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_VIDEO],
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
     * Lists of all videos (admin view)
     *
     * @return mixed
     */
    public function actionAdmin()
    {

        $dataProvider = new ActiveDataProvider(
            [
                'query' => Video::find()->orderBy('published DESC')->withCommentsCount(),
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
     * Creates a new video
     *
     * If creation is successful, the browser will be redirected to the 'admin' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Video();

        $model->scenario = UserPermissions::canAdminPost() ? Material::SCENARIO_ADMIN : Material::SCENARIO_CREATE;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['video/admin']);
        } else {
            return $this->render('create', ['model' => $model]);
        }
    }

    /**
     * Updates an existing video
     *
     * If update is successful, the browser will be redirected to the 'watch' page
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws ForbiddenHttpException
     * @throws NotFoundHttpException
     */
    public function actionUpdate(int $id)
    {

        $model = $this->findModel($id);

        if (!UserPermissions::canEditVideo($model)) {
            throw new ForbiddenHttpException('Вы не можете редактировать это видео.');
        }

        $model->scenario = UserPermissions::canAdminVideo() ? Material::SCENARIO_ADMIN : Material::SCENARIO_UPDATE;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/video/watch', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model,]);
        }
    }

    /**
     * Lists all videos with applied sorting
     *
     * @param string|null $sortBy
     *
     * @return mixed
     */
    public function actionIndex(string $sortBy = null)
    {

        if ($sortBy === null || !in_array($sortBy, VideoSearch::SORT_BY)) {
            $searchModel = new VideoSearch();
        } else {
            $searchModel = new VideoSearch(['sortBy' => $sortBy]);
        }

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams),
        ]);
    }

    /**
     * Action category
     *
     * @param $categoryName
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionCategory(string $categoryName)
    {

        $category = Category::findOne(['slug' => $categoryName, 'material_id' => Material::MATERIAL_VIDEO_ID]);

        if (!$category) {
            throw new NotFoundHttpException("Категория не найдена.");
        }

        $searchModel = new VideoSearch([
            'categoryId' => $category->id,
        ]);

        return $this->render('category', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams),
            'categoryName' => $category->name
        ]);
    }

    /**
     * Action watch
     *
     * @param int $id Id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionWatch(int $id)
    {

        $model = Video::findOne([
            'id' => $id,
            'status_id' => Material::STATUS_PUBLIC
        ]);

        if (!$model) {
            throw new NotFoundHttpException("Видео не найдено.");
        }

        $model->countHits(Material::MATERIAL_VIDEO_NAME);

        return $this->render('watch', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing video model.
     *
     * If deletion is successful, the browser will be redirected to the 'admin' page.
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws NotFoundHttpException if the model cannot be found
     * @throws \Throwable
     * @throws \yii\db\StaleObjectException
     */
    public function actionDelete(int $id)
    {

        $this->findModel($id)->delete();

        return $this->redirect(['admin']);
    }

    /**
     * Finds the video model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Video the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {

        if (($model = Video::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Видео не найдено.');
    }
}
