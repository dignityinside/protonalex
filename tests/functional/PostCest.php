<?php

use app\tests\fixtures\CategoryFixture;
use app\tests\fixtures\PostFixture;
use app\tests\fixtures\UserFixture;

class PostCest
{

    public function _before(FunctionalTester $I): void
    {
        $I->haveFixtures([
            'user' => [
                'class'    => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'post' => [
                'class'    => PostFixture::class,
                'dataFile' => codecept_data_dir() . 'post.php',
            ],
            'category' => [
                'class'    => CategoryFixture::class,
                'dataFile' => codecept_data_dir() . 'category.php',
            ],
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryOpenPostIndexPage(FunctionalTester $I): void
    {
        $I->wantTo('Open post index page');

        $I->amOnPage('/post/index');
        $I->see(\Yii::t('app/blog', \Yii::$app->params['siteName']));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryOpenPostViewPage(FunctionalTester $I): void
    {
        $I->wantTo('Open post view page');

        $post = $I->grabFixture('post', 0);

        $I->amOnRoute('post/view', ['slug' => $post->slug]);
        $I->see('Hello world!');
        $I->see('My first blog post.');
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryOpenPremiumPostViewPage(FunctionalTester $I): void
    {
        $I->wantTo('Open post view page');

        $post = $I->grabFixture('post', 1);

        $I->amOnRoute('post/view', ['slug' => $post->slug]);
        $I->see('Premium post');
        $I->see('My first premium blog post.');
        $I->see(\Yii::t('app', 'continue_only_premium'));
        $I->see(\Yii::t('app', 'button_get_premium'));
        $I->see(\Yii::t('app', 'button_already_premium'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryOpenPostAdminPageAsGuest(FunctionalTester $I): void
    {
        $I->wantTo('Open post admin page as guest');

        $I->amOnPage('/post/admin');
        $I->dontSee(\Yii::t('app/blog', 'posts'));
        $I->dontSee(\Yii::t('app/blog', 'button_add_new_post'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCreatePostAsGuest(FunctionalTester $I): void
    {
        $I->wantTo('Open create new post as guest');

        $I->amOnPage('/post/create');
        $I->dontSee(\Yii::t('app/blog', 'title_add_new_post'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryUpdatePostAsGuest(FunctionalTester $I): void
    {
        $I->wantTo('Open update post page as guest');

        $I->amOnPage('/post/update/1');
        $I->dontSee(\Yii::t('app/blog', 'title_update_post'));
    }
}
