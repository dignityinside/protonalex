<?php

namespace app\controllers;

use Yii;
use app\models\Post;
use app\models\PostSearch;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use app\components\UserPermissions;
use yii\web\ForbiddenHttpException;

/**
 * PostController implements the CRUD actions for Post model.
 *
 * @package app\controllers
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class PostController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['create', 'admin', 'update', 'delete', 'my'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['create', 'update', 'my'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_POST],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all posts
     *
     * @return mixed
     */
    public function actionIndex()
    {

        $query = Post::find()->where(
            [
                'status_id' => Post::STATUS_PUBLIC,
                'ontop'     => Post::SHOW_ON_TOP
            ]
        )->orderBy('datecreate DESC');

        $query->withCommentsCount()->all();

        $dataProvider = new ActiveDataProvider(
            [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );

        return $this->render(
            'index', [
            'dataProvider' => $dataProvider,
        ]
        );

    }

    /**
     * @param $id
     *
     * @return string
     */
    public function actionBlog($id)
    {

        $id = (int)$id;

        $query = Post::find()->where(
            [
                'status_id' => Post::STATUS_PUBLIC,
                'ontop'     => Post::SHOW_ON_TOP,
                'user_id'   => $id
            ]
        )->orderBy('datecreate DESC');

        $query->withCommentsCount()->all();

        $dataProvider = new ActiveDataProvider(
            [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 10,
                ],
            ]
        );

        return $this->render(
            'index', [
            'dataProvider' => $dataProvider,
        ]
        );

    }

    /**
     * @return string
     */
    public function actionAdmin()
    {

        $searchModel = new PostSearch();

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render(
            'admin', [
            'searchModel'  => $searchModel,
            'dataProvider' => $dataProvider,
        ]
        );

    }

    /**
     * @return string
     */
    public function actionMy()
    {

        $query = Post::find()->where(
            [
                'user_id' => Yii::$app->user->id,
            ]
        )->orderBy('datecreate DESC');

        $dataProvider = new ActiveDataProvider(
            [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );

        return $this->render(
            'my', [
            'dataProvider' => $dataProvider,
        ]
        );

    }

    /**
     * Display a single post model
     *
     * @param integer $id Id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {

        $model = Post::find()->where(['id' => $id])->withCommentsCount()->one();

        if (!$model) {
            throw new NotFoundHttpException('Запись не найдена.');
        }

        $model->countViews();

        return $this->render(
            'view', [
            'model' => $model
        ]
        );

    }

    /**
     * Creates a new Post model
     *
     * If creation is successful, the browser will be redirected to the 'view' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Post();

        if (UserPermissions::canAdminPost()) {
            $model->scenario = Post::SCENARIO_ADMIN;
        } else {
            $model->scenario = Post::SCENARIO_CREATE;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {

            return $this->render(
                'create', [
                'model' => $model,
            ]
            );

        }

    }

    /**
     * Updates an existing Post model
     *
     * If update is successful, the browser will be redirected to the 'view' page
     *
     * @param integer $id
     *
     * @return mixed
     *
     * @throws ForbiddenHttpException
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if (!UserPermissions::canEditPost($model)) {
            throw new ForbiddenHttpException('Вы не можете редактировать эту запись.');
        }

        if (UserPermissions::canAdminPost()) {
            $model->scenario = Post::SCENARIO_ADMIN;
        } else {
            $model->scenario = Post::SCENARIO_UPDATE;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render(
                'update', [
                'model' => $model,
            ]
            );
        }
    }

    /**
     * Deletes an existing Post model
     *
     * If deletion is successful, the browser will be redirected to the 'index' page
     *
     * @param integer $id
     *
     * @return mixed
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the Post model based on its primary key value
     *
     * If the model is not found, a 404 HTTP exception will be thrown
     *
     * @param integer $id
     *
     * @return Post the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {

        if (($model = Post::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('Запись не найдена.');
        }

    }
}
