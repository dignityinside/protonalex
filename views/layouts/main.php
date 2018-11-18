<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\assets\HighlightAsset;
use app\components\UserPermissions;

AppAsset::register($this);
HighlightAsset::register($this);

$googleSiteVerification = \Yii::$app->params['googleSiteVerification'];
$yandexVerification = \Yii::$app->params['yandexVerification'];

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?php if ($googleSiteVerification) : ?>
        <meta name="google-site-verification" content="<?=\Yii::$app->params['googleSiteVerification'];?>">
    <?php endif; ?>
    <?php if ($yandexVerification) : ?>
        <meta name="yandex-verification" content="<?=\Yii::$app->params['yandexVerification'];?>" />
    <?php endif; ?>
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <div class="header_container">
        <div class="container header">
            <?= Html::a('<img src="/img/rooland-logo.png" alt="rooland" class="header_logo">', Yii::$app->homeUrl); ?>
        </div>
    </div>

    <?php

    NavBar::begin(
        [
            'options'    => [
                'class' => 'navbar-inverse',
            ],
        ]
    );

    $menuItems[] = ['label' => 'Главная', 'url' => ['/post/index']];
    $menuItems[] = ['label' => 'Планета', 'url' => ['/planet/index']];
    $menuItems[] = ['label' => 'О проекте', 'url' => ['/site/about']];
    $menuItems[] = ['label' => 'Telegram', 'url' => 'https://t.me/roolandorg', 'linkOptions' => ['target' => '_blank']];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {

        $menuItems[] = [
            'label' => 'Панель', 'items' => [
                ['label' => 'Мои записи', 'url' => ['/post/my']],
                ['label' => 'Профиль', 'url' => ['/user/view', 'id' => \Yii::$app->user->id]],
                Yii::$app->user->can('admin') ? '<li class="divider"></li>' : '',
                ['label' => 'Все записи', 'url' => ['/post/admin'], 'visible' => UserPermissions::canAdminPost()],
                ['label' => 'Все категории', 'url' => ['/category/admin'], 'visible' => UserPermissions::canAdminCategory()],
                ['label' => 'Все пользователи', 'url' => ['/user/admin'], 'visible' => UserPermissions::canAdminUsers()],
                ['label' => 'Все комментарии', 'url' => ['/comment-admin/manage/index'], 'visible' => UserPermissions::canAdminPost()],
                ['label' => 'Планета', 'url' => ['/planet/admin'], 'visible' => UserPermissions::canAdminPlanet()],
            ],
        ];

        $menuItems[] = ['label' => 'Выйти (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']];

    }

    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items'   => $menuItems,
        ]
    );

    echo $this->render('partials/search.php');

    NavBar::end();

    ?>

    <div class="container">
        <?= Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        <?= $content ?>
    </div>
</div>

<footer>
    <div class="container footer">
        <p>&copy; <?= date('Y') ?> Сообщество rooland | <a href="/site/contact">Обратная связь</a></p>
    </div>
</footer>

<?php $this->endBody() ?>

<script>hljs.initHighlightingOnLoad();</script>

<!-- Yandex.Metrika counter --> <script> (function (d, w, c) { (w[c] = w[c] || []).push(function() { try { w.yaCounter15912202 = new Ya.Metrika({ id:15912202, clickmap:true, trackLinks:true, accurateTrackBounce:true }); } catch(e) { } }); var n = d.getElementsByTagName("script")[0], s = d.createElement("script"), f = function () { n.parentNode.insertBefore(s, n); }; s.type = "text/javascript"; s.async = true; s.src = "https://mc.yandex.ru/metrika/watch.js"; if (w.opera == "[object Opera]") { d.addEventListener("DOMContentLoaded", f, false); } else { f(); } })(document, window, "yandex_metrika_callbacks"); </script> <noscript><div><img src="https://mc.yandex.ru/watch/15912202" style="position:absolute; left:-9999px;" alt="" /></div></noscript> <!-- /Yandex.Metrika counter -->

</body>
</html>
<?php $this->endPage() ?>
