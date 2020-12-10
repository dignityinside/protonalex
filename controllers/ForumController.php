<?php

namespace app\controllers;

use app\components\UserPermissions;
use app\models\category\Category;
use app\models\forum\Forum;
use app\models\forum\ForumSearch;
use app\models\forum\ForumCategories;
use app\models\Material;
use app\models\User;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * ForumController implements the CRUD actions for Forum model.
 *
 * @author Alexander Schilling
 */
class ForumController extends Controller
{

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'topics', 'topic', 'user', 'create', 'update', 'my', 'admin', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'topics', 'topic', 'user'],
                        'allow'   => true,
                        'roles'   => ['?', '@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['create', 'update', 'my'],
                        'roles'   => ['@'],
                    ],
                    [
                        'allow'   => true,
                        'actions' => ['admin', 'delete'],
                        'roles'   => [UserPermissions::ADMIN_FORUM],
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
     * Returns actions
     *
     * @return array
     */
    public function actions(): array
    {
        $this->layout = "/forum";

        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Lists of all topics (admin view)
     *
     * @return mixed
     */
    public function actionAdmin()
    {

        $dataProvider = new ActiveDataProvider(
            [
                'query' => Forum::find()->orderBy('created_at DESC')->withCommentsCount(),
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
     * List current user topics
     *
     * @return string
     */
    public function actionMy()
    {

        $query = Forum::find()->where(['user_id' => \Yii::$app->user->id])->withCommentsCount()->orderBy('created_at DESC');

        $dataProvider = new ActiveDataProvider(
            [
                'query'      => $query,
                'pagination' => [
                    'pageSize' => 15,
                ],
            ]
        );

        return $this->render('my', ['dataProvider' => $dataProvider]);
    }

    /**
     * Creates a topic
     *
     * If creation is successful, the browser will be redirected to the 'my' page.
     *
     * @param int|null $id
     *
     * @return mixed
     */
    public function actionCreate(?int $id = null)
    {

        $categoryId = $id !== null ? $id : 0;

        $model = new Forum();

        $model->scenario = UserPermissions::canAdminForum() ? Material::SCENARIO_ADMIN : Material::SCENARIO_CREATE;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['forum/my']);
        }

        return $this->render('create', ['model' => $model, 'categoryId' => $categoryId]);
    }

    /**
     * Updates an existing topic
     *
     * If update is successful, the browser will be redirected to the 'view' page
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

        if (!UserPermissions::canEditForum($model)) {
            throw new ForbiddenHttpException('Вы не можете редактировать эту тему.');
        }

        $model->scenario = UserPermissions::canAdminForum() ? Material::SCENARIO_ADMIN : Material::SCENARIO_UPDATE;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/forum/topic', 'id' => $model->id]);
        }

        return $this->render('update', ['model' => $model,]);
    }

    /**
     * List of all categories
     *
     * @return string
     */
    public function actionIndex()
    {

        $searchModel = new ForumCategories();

        return $this->render('index', ['dataProvider' => $searchModel->search()]);
    }

    /**
     * List of all topics filtered by category name and sorted by...
     *
     * @param string|null $categoryName
     * @param string|null $sortBy
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionTopics(string $categoryName = null, string $sortBy = null)
    {

        if ($categoryName === null) {
            return $this->redirect(['forum/index']);
        }

        if ($categoryName === 'new') {
            $searchModel = new ForumSearch(['sortBy' => $sortBy]);

            return $this->render('topics', [
                'searchModel' => $searchModel,
                'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams)
            ]);
        }

        // filter by category name

        $category = Category::findOne(['slug' => $categoryName, 'material_id' => Material::MATERIAL_FORUM_ID]);

        if (!$category) {
            throw new NotFoundHttpException("Форум не найден.");
        }

        // sort by

        if ($sortBy === null || !in_array($sortBy, ForumSearch::SORT_BY)) {
            $searchModel = new ForumSearch(['categoryId' => $category->id]);
        } else {
            $searchModel = new ForumSearch([
                'categoryId' => $category->id,
                'sortBy' => $sortBy
            ]);
        }

        return $this->render('topics', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams),
            'categoryModel' => $category
        ]);
    }

    /**
     * Lists all topics from user
     *
     * @param string|null $userName
     *
     * @return mixed
     *
     * @throws NotFoundHttpException
     */
    public function actionUser(string $userName = null)
    {

        $user = User::findOne(['username' => $userName]);

        if (!$user) {
            throw new NotFoundHttpException("Пользователь ещё не опубликовал ни одной темы.");
        }

        $searchModel = new ForumSearch(['userId' => $user->id]);

        return $this->render('user', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams),
            'userName' => $user->username
        ]);
    }

    /**
     * Action topic
     *
     * @param int $id Id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionTopic(int $id)
    {

        $model = Forum::findOne([
            'id' => $id,
            'status_id' => Material::STATUS_PUBLIC
        ]);

        if (!$model) {
            throw new NotFoundHttpException("Тема не найдена.");
        }

        $model->countHits(Material::MATERIAL_FORUM_NAME);

        return $this->render('topic', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing topic model.
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
     * Finds the forum model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Forum the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {

        if (($model = Forum::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Форум не найден.');
    }
}