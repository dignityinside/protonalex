<?php

use app\components\UserPermissions;
use app\models\User;
use app\widgets\Avatar;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\User */
/* @var $authClients \yii\authclient\ClientInterface[] */

$this->title = $model->username;
$this->params['breadcrumbs'][] = 'Пользователи';
$this->params['breadcrumbs'][] = $this->title;

?>
<div class="row user-view">
    <div class="col-xs-12">
        <div class="row">
            <div class="col-sm-12 clearfix">
                <div class="user-view-avatar">
                    <?= Avatar::widget(['user' => $model, 'size' => 165]) ?>
                </div>

                <?php if (isset(\Yii::$app->user->identity) && $model->id === \Yii::$app->user->identity->getId()) : ?>

                    <?php if ($model->isExpired($model->premium_until)) : ?>

                        <?php if ($model->status === User::STATUS_WAIT) : ?>
                            <h1>Почти готово, <?= Html::encode($model->username) ?>!</h1>
                            <p>Спасибо за то, что ты заказал(а) премиум доступ на <strong><?= ArrayHelper::getValue(User::getTariff(), $model->payment_tariff); ?></strong>.</p>
                            <p>Ты хочешь оплатить с помощью <strong><?= ArrayHelper::getValue(User::getPaymentTypes(), $model->payment_type); ?></strong> верно?</p>
                        <?php else : ?>
                            <h1>Ой, <?= Html::encode($model->username) ?>!</h1>
                            <p>Твоя премиум подписка закончилась <?= Yii::$app->formatter->asDate($model->premium_until) ?? '---' ?>, хочешь продлить её сейчас?</p>
                            <p>В прошлый раз ты заказывал(а) премиум доступ на <strong><?= ArrayHelper::getValue(User::getTariff(), $model->payment_tariff); ?></strong>
                                и оплачивал(а) с помощью <strong><?= ArrayHelper::getValue(User::getPaymentTypes(), $model->payment_type); ?></strong>.</p>
                        <?php endif; ?>

                        <p>Если всё верно, то переведи
                            <strong><?= $model::getPremiumPriceByTariff($model->payment_tariff); ?></strong>
                                на <?= ArrayHelper::getValue(User::getPaymentTypes(), $model->payment_type); ?>:
                            <strong><?= $model::getPaymentWallet($model->payment_type); ?></strong>
                            и укажи <strong>свой E-Mail</strong> в назначении платежа.</p>

                        <p>После оплаты, премиум доступ будет активирован в течение суток.</p>

                    <?php else : ?>
                        <?php if ($model->status === User::STATUS_PAID) : ?>

                            <h1>Спасибо <?= Html::encode($model->username) ?>!</h1>

                            <p>Теперь у тебя есть премиум доступ до <?= Yii::$app->formatter->asDate($model->premium_until) ?? '---' ?>
                                (<?= ArrayHelper::getValue(User::getTariff(), $model->payment_tariff); ?>).</p>

                        <?php endif; ?>
                    <?php endif; ?>

                    <p>Если у тебя остались вопросы или нужна помощь, напиши мне на <?= \Yii::$app->params['adminEmail'] ?></p>

                <?php endif; ?>

                <?php if (UserPermissions::canEditUser($model)) : ?>
                    <p>
                        <?php // echo Html::a('Изменить профиль', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
                    </p>
                <?php endif ?>
                <?php if (UserPermissions::canAdminUsers()) : ?>
                    <p>
                        <?= Html::a(
                            'Удалить',
                            ['delete', 'id' => $model->id],
                            [
                                'class' => 'btn btn-danger',
                                'data'  => [
                                    'confirm' => 'Вы уверены что хотите удалить свой аккаунт?',
                                    'method'  => 'post',
                                ],
                            ]
                        ) ?>
                    </p>
                <?php endif ?>
            </div>
        </div>
    </div>
</div>
