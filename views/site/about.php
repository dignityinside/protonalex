<?php

/* @var $this yii\web\View */

use yii\helpers\Html;

$this->title = 'Руланд блог';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="site-about">
    <h1><?= Html::encode($this->title) ?></h1>
    <p><strong>Обо мне</strong></p>
    <p>Здравствуйте!</p>
    <p>Меня зовут Александр Шиллинг (ник "дигнити", англ. "dignity").</p>
    <p>Это мой личный блог "Руланд" (англ. "rooland").</p>
    <p>В нём я пишу интересные истории из моей жизни, а также о своих увлечениях музыки, книгах, фильмах, играх и путешествиях.</p>
    <p>На данный момент побывал уже в Германии, Австрии, Франции, Италии, Испании, Греции, Голландии, Чехии, России, Украине и Казахстане.</p>
    <p>Отмечаю день рождения блога каждый год 21 июля, начиная с 2012 года.</p>
    <p><strong>Добавляйтесь в друзья:</strong></p>
    <div class="widget-content__social-icons">
        <ul>
            <?php
                $social = \Yii::$app->params['social'];
            ?>
            <li><a href="https://instagram.com/<?= $social['instagram'] ?>" target="_blank" rel="nofollow" title="Instagram"><i class="fab fa-instagram"></i> Instagram</a></li>
            <li><a href="https://t.me/roolandorg" target="_blank" rel="nofollow" title="Telegram канал"><i class="fa fa-telegram"></i> Telegram</a></li>
            <li><a href="https://mastodon.social/@roolandorg" target="_blank" rel="nofollow" title="Mastodon"><i class="fab fa-mastodon"></i> Mastodon</a></li>
        </ul>
    </div>
    <p><strong>Поддержите мой блог:</strong></p>
    <?php
        $donate = \Yii::$app->params['donate'];
    ?>
    <ul>
        <li>
            Яндекс.Деньги: <a href="https://money.yandex.ru/to/<?= $donate['yandexMoney']; ?>?lang=ru" target="_blank">
                <?= $donate['yandexMoney']; ?>
            </a>
        </li>
        <li>
            PayPal: <a href="https://www.paypal.me/<?= $donate['paypal'] ?>" target="_blank"><?= $donate['paypal'] ?></a>
        </li>
    </ul>
    <p>По вопросам сотрудничества и рекламы: dignityinside&commat;protonmail.com</p>
</div>
