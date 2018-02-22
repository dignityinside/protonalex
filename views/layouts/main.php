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
\app\assets\HighlightAsset::register($this);

?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
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
            'brandLabel' => Yii::$app->name,
            'brandUrl'   => Yii::$app->homeUrl,
            'options'    => [
                'class' => 'navbar-inverse navbar-fixed-top',
            ],
        ]
    );

    $menuItems[] = ['label' => 'О проекте', 'url' => ['/site/about']];
    $menuItems[] = ['label' => 'Обратная связь', 'url' => ['/site/contact']];

    if (Yii::$app->user->isGuest) {
        $menuItems[] = ['label' => 'Регистрация', 'url' => ['/site/signup']];
        $menuItems[] = ['label' => 'Войти', 'url' => ['/site/login']];
    } else {

        $menuItems[] = [
            'label' => 'Панель пользователя', 'items' => [
                ['label' => 'Добавить новую запись', 'url' => ['/post/create']],
                ['label' => 'Записи', 'url' => ['/post/my']],
                ['label' => 'Профиль', 'url' => ['/user/view', 'id' => \Yii::$app->user->id]],
                ['label'       => 'Выйти (' . Yii::$app->user->identity->username . ')', 'url' => ['/site/logout'],
                 'linkOptions' => ['data-method' => 'post']
                ],
            ]
        ];

        $menuItems[] = [
            'label'      => 'Админ-панель', 'items' => [
                ['label' => 'Записи', 'url' => ['/post/admin'], 'visible' => \Yii::$app->user->can('adminPost')],
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
        <p>&copy; <?= date('Y') ?> Сообщество phpland</p>
        <p>Копирование материалов разрешается только с указанием названия сайта (Сообщество phpland)<br> и индексируемой
            прямой ссылкой на сайт (https://phpland.org)</p>
    </div>
</footer>

<?php $this->endBody() ?>

<script>hljs.initHighlightingOnLoad();</script>
</body>
</html>
<?php $this->endPage() ?>
