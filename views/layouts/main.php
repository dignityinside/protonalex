<?php

/* @var $this \yii\web\View */

/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\components\UserPermissions;

AppAsset::register($this);

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
    <link rel="apple-touch-icon" sizes="60x60" href="/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/site.webmanifest">
    <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#8fca58">
    <meta name="msapplication-TileColor" content="#8fca58">
    <meta name="theme-color" content="#ffffff">
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

        <?php

        NavBar::begin(
            [
                'brandLabel' => Html::img('/img/rooland-logo.png'),
                'options'    => [
                    'class' => 'navbar-inverse',
                ],
            ]
        );

        $menuItems[] = ['label' => 'Блог', 'url' => ['/post/index']];
        $menuItems[] = ['label' => 'Видео', 'url' => ['/video/index']];
        $menuItems[] = ['label' => 'Скидки', 'url' => ['/deals/index']];
        $menuItems[] = ['label' => 'Форум', 'url' => ['/forum/index']];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => 'Войти', 'url' => ['/login']];
        } else {
            $menuItems[] = [
                'label' => 'Панель', 'items' => [
                    ['label' => 'Мои темы форума', 'url' => ['/forum/my']],
                    ['label' => 'Профиль', 'url' => ['/user/view', 'id' => \Yii::$app->user->id]],
                    Yii::$app->user->can('admin') ? '<li class="divider"></li>' : '',
                    ['label' => 'Записи', 'url' => ['/post/admin'], 'visible' => UserPermissions::canAdminPost()],
                    ['label' => 'Видео', 'url' => ['/video/admin'], 'visible' => UserPermissions::canAdminVideo()],
                    ['label' => 'Скидки', 'url' => ['/deals/admin'], 'visible' => UserPermissions::canAdminDeals()],
                    ['label' => 'Все темы форума', 'url' => ['/forum/admin'], 'visible' => UserPermissions::canAdminForum()],
                    ['label' => 'Комментарии', 'url' => ['/comment-admin/manage/index'], 'visible' => UserPermissions::canAdminPost()],
                    ['label' => 'Категории', 'url' => ['/category/admin'], 'visible' => UserPermissions::canAdminCategory()],
                    ['label' => 'Пользователи', 'url' => ['/user/admin'], 'visible' => UserPermissions::canAdminUsers()],
                    Yii::$app->user->can('admin') ? '<li class="divider"></li>' : '',
                    ['label' => 'Выйти (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'], 'linkOptions' => ['data-method' => 'post']]
                ],
            ];
        }

        echo Nav::widget(
            [
                'options' => ['class' => 'navbar-nav navbar-left'],
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

    <footer>
        <div class="container footer text-center">
            <p>&copy; 2012-<?= date('Y') ?> <?= \Yii::$app->params['siteName'] ?> |
                <?= Html::a('Об авторе', '/about'); ?></p>
            <p>Копирование и распространение материалов с сайта разрешено только с указанием активной ссылки.</p>
        </div>
    </footer>
</div>

<?php $this->endBody() ?>

<?= $this->render('partials/counter.php'); ?>

</body>
</html>
<?php $this->endPage() ?>
