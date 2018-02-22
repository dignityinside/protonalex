<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \app\models\LoginForm */

$this->title = 'Авторизация';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div class="row">
        <div class="col-sm-3 col-sm-offset-1">
            <?= yii\authclient\widgets\AuthChoice::widget(
                [
                    'baseAuthUrl' => ['site/auth'],
                    'popupMode'   => false,
                ]
            ) ?>
        </div>
        <div class="col-sm-2">
            <h2>или</h2>
        </div>
        <div class="col-sm-5">
            <?php $form = ActiveForm::begin(['id' => 'login-form']); ?>
            <?= $form->field($model, 'username') ?>
            <?= $form->field($model, 'password')->passwordInput() ?>
            <p class="hint-block">
                Если вы забыли свой пароль, вы можете его <?= Html::a(
                    'восстановить', ['site/request-password-reset']
                ) ?>.
            </p>
            <div class="form-group">
                <?= Html::submitButton('Войти', ['class' => 'btn btn-primary', 'name' => 'login-button']) ?>
            </div>
            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>