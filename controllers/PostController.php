<?php

namespace app\controllers;

use app\models\category\Category;
use app\models\Material;
use app\models\Tag;
use Yii;
use app\models\post\Post;
use app\models\post\PostSearch;
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
 * @author Alexander Schilling
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
                'class' => AccessControl::class,
                'only'  => ['index', 'view', 'category', 'tag', 'create', 'admin', 'update', 'delete'],
                'rules' => [
                    [
                        'allow'   => true,
                        'actions' => ['index', 'view', 'category', 'tag'],
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create', 'update', 'admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_POST],
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
     * Lists all posts
     *
     * @param null $id
     * @return mixed
     */
    public function actionIndex($id = null)
    {

        $this->layout = "/column2";

        $searchModel = new PostSearch([
            'sortBy' => (int) $id,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * @return string
     */
    public function actionAdmin()
    {

        $searchModel = new PostSearch();

        $dataProvider = $searchModel->adminSearch(Yii::$app->request->queryParams);

        return $this->render(
            'admin',
            [
                'searchModel'  => $searchModel,
                'dataProvider' => $dataProvider,
            ]
        );
    }

    /**
     * Display a single post model
     *
     * @param $slug
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView($slug)
    {

        $this->layout = "/blog";

        $model = Post::find()->where([
            'status_id' => Material::STATUS_PUBLIC,
            'slug' => $slug,
        ])->withCommentsCount()->one();

        if (!$model) {
            throw new NotFoundHttpException('Запись не найдена.');
        }

        $model->countHits(Material::MATERIAL_POST_NAME);

        return $this->render('view', ['model' => $model]);
    }

    /**
     * Creates a new Post model
     *
     * If creation is successful, the browser will be redirected to the 'admin' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Post();

        if (UserPermissions::canAdminPost()) {
            $model->scenario = Material::SCENARIO_ADMIN;
        } else {
            $model->scenario = Material::SCENARIO_CREATE;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['post/update', 'id' => $model->id]);
        }

        return $this->render('create', ['model' => $model]);
    }

    /**
     * Updates an existing Post model
     *
     * If update is successful, the browser will be redirected to the 'admin' page
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
            throw new ForbiddenHttpException('Вы не можете редактировать эту статью.');
        }

        if (UserPermissions::canAdminPost()) {
            $model->scenario = Material::SCENARIO_ADMIN;
        } else {
            $model->scenario = Material::SCENARIO_UPDATE;
        }

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['post/update', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model]);
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

        return $this->redirect(['admin']);
    }

    /**
     * Action tag
     *
     * @param $tagName
     *
     * @throws NotFoundHttpException
     *
     * @return string
     */
    public function actionTag($tagName)
    {

        $tag = Tag::findOne(['name' => $tagName]);

        if (!$tag) {
            throw new NotFoundHttpException("Такой тэг не найден.");
        }

        $searchModel = new PostSearch([
            'tagId' => $tag->id,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('tag', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'tagName' => $tag->name
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
    public function actionCategory($categoryName)
    {

        $category = Category::findOne([
            'slug' => $categoryName,
            'material_id' => Material::MATERIAL_POST_ID
        ]);

        if (!$category) {
            throw new NotFoundHttpException("Категория не найдена.");
        }

        $searchModel = new PostSearch([
            'categoryId' => $category->id,
        ]);

        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('category', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
            'categoryName' => $category->name
        ]);
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
        }

        throw new NotFoundHttpException('Статья не найдена.');
    }
}
