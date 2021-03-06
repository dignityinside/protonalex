<?php

/* @var $this yii\web\View */
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
<html lang="<?= Yii::$app->language ?>" prefix="og: http://ogp.me/ns#">
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
    <?= $this->render('partials/head.php'); ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

        <?php

        NavBar::begin(
            [
                'brandLabel' => \Yii::$app->params['site']['name'],
                'options'    => [
                    'class' => 'navbar-inverse',
                ],
            ]
        );

        $menuItems[] = ['label' => \Yii::t('app/blog', 'menu_label_index_blog'), 'url' => ['/post/index']];

        $menuItems[] = ['label' => \Yii::t('app/forum', 'menu_label_forum_index'), 'url' => ['/forum/index']];

        if (Yii::$app->user->isGuest) {
            $menuItems[] = ['label' => \Yii::t('app', 'menu_label_login'), 'url' => ['/login']];
        } else {

            $menuItems[] = [
                'label' => \Yii::t('app', 'menu_label_profile'),
                'url' => ['/user/view', 'id' => \Yii::$app->user->id]
            ];

            if (Yii::$app->user->can('admin')) {

                $menuItems[] = [
                    'label' => \Yii::t('app', 'menu_label_panel'), 'items' => [
                        [
                            'label' => \Yii::t('app/blog', 'menu_label_admin_blog'),
                            'url' => ['/post/admin'],
                            'visible' => UserPermissions::canAdminPost()
                        ],
                        [
                            'label' => \Yii::t('app/comments', 'menu_label_admin_comments'),
                            'url' => ['/comment-admin/manage/index'],
                            'visible' => UserPermissions::canAdminPost()
                        ],
                        [
                            'label' => \Yii::t('app/forum', 'menu_label_forum_admin'),
                            'url' => ['/forum/admin'],
                            'visible' => UserPermissions::canAdminForum()
                        ],
                        [
                            'label' => \Yii::t('app/category', 'menu_label_admin_category'),
                            'url' => ['/category/admin'],
                            'visible' => UserPermissions::canAdminCategory()
                        ],
                        [
                            'label' => \Yii::t('app', 'menu_label_user_admin'),
                            'url' => ['/user/admin'],
                            'visible' => UserPermissions::canAdminUsers()
                        ],
                        [
                            'label' => \Yii::t('app', 'menu_label_ad_admin'),
                            'url' => ['/ad/admin'],
                            'visible' => UserPermissions::canAdminAd()
                        ],
                    ],
                ];

            }

            $menuItems[] = [
                'label' => \Yii::t('app', 'logout_({username})', [
                    'username' => Yii::$app->user->identity->username,
                ]),
                'url' => ['/site/logout'],
                'linkOptions' => ['data-method' => 'post']
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

    <div class="container-fluid">
        <?= Breadcrumbs::widget(
            [
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]
        ) ?>
        <?= $content ?>
    </div>

    <footer>
        <div class="container footer text-center">
            <p>&copy; <?= date('Y') ?> <?= \Yii::$app->params['site']['name'] ?> |
                <?= Html::a(\Yii::t('app', 'footer_about_link'), '/about'); ?> |
                <?= Html::a(\Yii::t('app', 'footer_premium_link'), '/premium'); ?> |
                <?= Html::a(\Yii::t('app', 'footer_contact_link'), '/contact'); ?>
            </p>
        </div>
    </footer>
</div>

<?php

    $this->endBody();

    if (YII_ENV == YII_ENV_PROD) {
        echo $this->render('partials/counter.php');
    }

?>

</body>
</html>
<?php $this->endPage() ?>
