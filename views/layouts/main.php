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
    <?php

    NavBar::begin(
        [
            'brandLabel' => '<span>rooland</span>',
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse',
            ],
        ]
    );

    $menuItems[] = ['label' => 'Главная', 'url' => ['/post/index']];
    $menuItems[] = ['label' => 'О проекте', 'url' => ['/site/about']];
    $menuItems[] = ['label' => 'Telegram', 'url' => 'https://t.me/roolandorg', 'linkOptions' => ['target' => '_blank']];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {

        $menuItems[] = [
            'label' => 'Панель пользователя', 'items' => [
                ['label' => 'Мои записи', 'url' => ['/post/my']],
                ['label' => 'Профиль', 'url' => ['/user/view', 'id' => \Yii::$app->user->id]],
                ['label'       => 'Выйти (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'],
                 'linkOptions' => ['data-method' => 'post']
                ],
            ]
        ];

        $menuItems[] = [
            'label'      => 'Админ-панель', 'items' => [
                ['label' => 'Записи', 'url' => ['/post/admin'], 'visible' => \Yii::$app->user->can('adminPost')],
                ['label' => 'Категории', 'url' => ['/category/admin'], 'visible' => UserPermissions::canAdminCategory()],
                ['label' => 'Пользователи', 'url' => ['/user/admin'], 'visible' => UserPermissions::canAdminUsers()],
                ['label' => 'Комментарии', 'url' => ['/comment-admin/manage/index']]
            ], 'visible' => Yii::$app->user->can('admin')
        ];

    }

    echo Nav::widget(
        [
            'options' => ['class' => 'navbar-nav navbar-right'],
            'items'   => $menuItems,
        ]
    );

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

</body>
</html>
<?php $this->endPage() ?>
