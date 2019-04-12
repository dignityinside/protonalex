<?php

namespace app\controllers;

use app\components\UserPermissions;
use app\models\Category;
use app\models\User;
use app\models\Deals;
use app\models\DealsSearch;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\ForbiddenHttpException;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * DealsController implements the CRUD actions for Deals model.
 *
 * @author Alexander Schilling
 */
class DealsController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'only'  => ['index', 'view', 'category', 'user', 'create', 'update', 'my', 'admin', 'delete'],
                'rules' => [
                    [
                        'actions' => ['index', 'category', 'view', 'user'],
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
                        'roles'   => [UserPermissions::ADMIN_DEALS],
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
     * Lists of all deals (admin view)
     *
     * @return mixed
     */
    public function actionAdmin()
    {

        $dataProvider = new ActiveDataProvider(
            [
                'query' => Deals::find()->orderBy('created DESC'),
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
     * List current user deals
     *
     * @return string
     */
    public function actionMy()
    {

        $query = Deals::find()->where(['user_id' => \Yii::$app->user->id])->orderBy('created DESC');

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
     * Creates a new deal
     *
     * If creation is successful, the browser will be redirected to the 'my' page.
     *
     * @return mixed
     */
    public function actionCreate()
    {

        $model = new Deals();

        $model->scenario = UserPermissions::canAdminDeals() ? Deals::SCENARIO_ADMIN : Deals::SCENARIO_CREATE;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['deals/my']);
        } else {
            return $this->render('create', ['model' => $model]);
        }

    }

    /**
     * Updates an existing deal
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

        if (!UserPermissions::canEditDeals($model)) {
            throw new ForbiddenHttpException('Вы не можете редактировать эту сделку.');
        }

        $model->scenario = UserPermissions::canAdminDeals() ? Deals::SCENARIO_ADMIN : Deals::SCENARIO_UPDATE;

        if ($model->load(\Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['/deals/view', 'id' => $model->id]);
        } else {
            return $this->render('update', ['model' => $model,]);
        }

    }

    /**
     * Lists all deals with applied sorting
     *
     * @param string|null $sortBy
     *
     * @return mixed
     */
    public function actionIndex(string $sortBy = null)
    {

        if ($sortBy === null || !in_array($sortBy, DealsSearch::SORT_BY)) {
            $searchModel = new DealsSearch();
        } else {
            $searchModel = new DealsSearch(['sortBy' => $sortBy]);
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
    public function actionCategory(string $categoryName) {

        $category = Category::findOne(['slug' => $categoryName, 'material_id' => Category::MATERIAL_DEALS]);

        if (!$category) {
            throw new NotFoundHttpException("Категория не найдена.");
        }

        $searchModel = new DealsSearch([
            'categoryId' => $category->id,
        ]);

        return $this->render('category', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams),
            'categoryName' => $category->name
        ]);

    }

    /**
     * Lists all deals from user
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
            throw new NotFoundHttpException("Пользователь ещё не публиковал ни одной сделки.");
        }

        $searchModel = new DealsSearch(['userId' => $user->id]);

        return $this->render('user', [
            'searchModel' => $searchModel,
            'dataProvider' => $searchModel->search(\Yii::$app->request->queryParams),
            'userName' => $user->username
        ]);

    }

    /**
     * Action view
     *
     * @param int $id Id
     *
     * @return string
     *
     * @throws NotFoundHttpException
     */
    public function actionView(int $id)
    {

        $model = Deals::findOne([
            'id' => $id,
            'status_id' => Deals::STATUS_PUBLIC
        ]);

        if (!$model) {
            throw new NotFoundHttpException("Сделки не найдены.");
        }

        $model->countViews();

        return $this->render('view', [
            'model' => $model,
        ]);

    }

    /**
     * Deletes an existing deal model.
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
     * Finds the deals model based on its primary key value.
     *
     * If the model is not found, a 404 HTTP exception will be thrown.
     *
     * @param int $id
     *
     * @return Deals the loaded model
     *
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel(int $id)
    {

        if (($model = Deals::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('Cделки не найдены.');

    }
}
