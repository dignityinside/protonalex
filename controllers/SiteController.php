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
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;

/**
 * Class SiteController
 *
 * @package app\controllers
 *
 * @author Alexander Schilling
 */
class SiteController extends Controller
{

    /**
     * Returns behaviors
     *
     * @return array
     */
    public function behaviors(): array
    {

        return [
            'access' => [
                'class' => AccessControl::class,
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
                'class'   => VerbFilter::class,
                'actions' => [
                    'logout' => ['post'],
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

    /**
     * On auth success
     *
     * @param $client
     */
    public function onAuthSuccess($client)
    {
        (new AuthHandler($client))->handle();
    }

    /**
     * Display login page
     *
     * @return string|\yii\web\Response
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

        return $this->render('login', ['model' => $model]);
    }

    /**
     * Log out user
     *
     * @return \yii\web\Response
     */
    public function actionLogout()
    {

        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Display signup page
     *
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

        return $this->render('signup', ['model' => $model]);
    }

    /**
     * Display request password reset page
     *
     * @return string|\yii\web\Response
     */
    public function actionRequestPasswordReset()
    {

        $model = new PasswordResetRequestForm();

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->getSession()->setFlash(
                    'success',
                    'Проверьте электронную почту для получения дальнейших инструкций.'
                );

                return $this->goHome();
            }

            Yii::$app->getSession()->setFlash('error', 'Извините, мы не можем сбросить ваш пароль.');
        }

        return $this->render(
            'requestPasswordResetToken',
            [
            'model' => $model,
            ]
        );
    }

    /**
     * Display reset password page
     *
     * @param string $token
     *
     * @return string|\yii\web\Response
     *
     * @throws BadRequestHttpException
     */
    public function actionResetPassword(string $token)
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
            'resetPassword',
            [
            'model' => $model,
            ]
        );
    }

    /**
     * Displays contact page
     *
     * @return string|\yii\web\Response
     */
    public function actionContact()
    {
        $model = new ContactForm();

        if ($model->load(Yii::$app->request->post()) && $model->contact()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }

        return $this->render('contact', ['model' => $model]);
    }

    /**
     * Displays search page
     *
     * @return string
     */
    public function actionSearch(): string
    {
        return $this->render('search');
    }
}
