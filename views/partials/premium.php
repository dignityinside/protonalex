<?php

    use yii\helpers\Html;

?>
<div class="premium">
    <p class="premium__header">Продолжение доступно только для премиум пользователя!</p>
    <div class="premium__price">
        <div class="premium_price__month">
            <span class="premium_price__length">1 Месяц</span>
            <span class="premium_price__value">
                <?= \Yii::$app->params['premium']['price']; ?> р.
            </span>
        </div>
        <div class="premium_price__year">
            <span class="premium_price__length">12 Месяцев</span>
            <span class="premium_price__value">
                <s><?= \Yii::$app->params['premium']['price'] * 12; ?> р.</s>
            </span>
            <span style="color: #d43f3a">
                <?= \Yii::$app->params['premium']['price'] * (12 - \Yii::$app->params['premium']['freeMonth']); ?> р.
                (<?php

                    $month = \Yii::$app->params['premium']['freeMonth'];

                    echo $month;

                    if ($month === 1) {
                        echo " Месяц";
                    } else if ($month <= 4) {
                        echo " Месяца";
                    } else {
                        echo " Месяцев";
                    }

                ?> в подарок)
            </span>
        </div>
    </div>
    <p class="premium_price__button_box">
        <?= Html::a('Получить премиум', '/premium', ['class' => 'btn btn-danger btn-lg btn-block', 'style' => 'color: #fff;']) ?>
    </p>
    <p>
        <?php if (\Yii::$app->user->identity === null) : ?>
            <?= Html::a('Я уже премиум', '/login') ?>
        <?php endif; ?>
    </p>
</div>
