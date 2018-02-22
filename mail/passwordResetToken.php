<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $user app\models\User */

$resetLink = Yii::$app->urlManager->createAbsoluteUrl(['site/reset-password', 'token' => $user->password_reset_token]);

?>

Привет <?= Html::encode($user->username) ?>,

Перейди по ссылки, чтобы сбросить пароль:

<?= Html::a(Html::encode($resetLink), $resetLink) ?>
