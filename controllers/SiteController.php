<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\components\AuthHandler;
use app\models\PasswordResetRequestForm;
use app\models\ResetPasswordForm;
use app\models\SignupForm;
use yii\authclient\ClientInterface;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

/**
 * Class SiteController
 *
 * @package app\controllers
 *
 * @author Alexander Schilling <dignityinside@gmail.com>
 */
class SiteController extends Controller
{

    /**
     * @inheritdoc
     */
    public function behaviors()
    {

        return [
            'access' => [
                'class' => AccessControl::className(),
                'only'  => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow'   => true,
                        'roles'   => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow'   => true,
                        'roles'   => ['@'],
                    ],
                ],
            ],
            'verbs'  => [
                'class'   => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];

    }

    /**
     * @inheritdoc
     */
    public function actions()
    {

        return [
            'error'   => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class'           => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
            'auth'    => [
                'class'           => 'yii\authclient\AuthAction',
                'successCallback' => [$this, 'onAuthSuccess'],
            ],
        ];

    }

    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * @return string
     */
    public function actionLogin()
    {

        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        return $this->render(
            'login', [
            'model' => $model,
        ]
        );

    }

    /**
     * @return \yii\web\Response
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();

    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionSignup()
    {

        $model = new SignupForm();

        if ($model->load(Yii::$app->request->post())) {

            if ($user = $model->signup()) {

                if (Yii::$app->getUser()->login($user, Yii::$app->params['user.rememberMeDuration'])) {
                    return $this->goHome();
                }

            }

        }

        return $this->render(
            'signup', [
            'model' => $model,
        ]
        );

    }

    /**
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {

        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {

            if ($model->sendEmail()) {

                Yii::$app->getSession()->setFlash(
                    'success', 'Проверьте электронную почту для получения дальнейших инструкций.'
                );

                return $this->goHome();

            }

            Yii::$app->getSession()->setFlash('error', 'Извините, мы не можем сбросить ваш пароль.');

        }

        return $this->render(
            'requestPasswordResetToken', [
            'model' => $model,
        ]
        );

    }

    /**
     * @param string $token
     *
     * @return string|\yii\web\Response
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->getSession()->setFlash('success', 'Новый пароль был сохранен.');

            return $this->goHome();
        }

        return $this->render(
            'resetPassword', [
            'model' => $model,
        ]
        );

    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {

        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {

            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();

        }

        return $this->render(
            'contact', [
            'model' => $model,
        ]
        );

    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionMiner()
    {
        return $this->render('miner');
    }

}
