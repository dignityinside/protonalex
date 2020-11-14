<?php

use app\tests\fixtures\CategoryFixture;
use app\tests\fixtures\PostFixture;
use app\tests\fixtures\UserFixture;

class PostCest
{

    protected $formId = '#form-post';

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
            ]
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCreatePostAsGuest(FunctionalTester $I): void
    {
        $I->wantTo('Create new post as guest');

        $I->amOnPage('/post/create');
        $I->dontSee(\Yii::t('app/blog', 'title_add_new_post'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryUpdatePostAsGuest(FunctionalTester $I): void
    {
        $I->wantTo('Update post as guest');

        $I->amOnPage('/post/update/1');
        $I->dontSee(\Yii::t('app/blog', 'title_update_post'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCreatePostWithEmptyField(FunctionalTester $I): void
    {
        $I->wantTo('Create new post, with empty fields');

        $I->amLoggedInAs(\app\models\User::findByUsername('test'));
        $I->amOnPage('/post/create');
        $I->see(\Yii::t('app/blog', 'title_add_new_post'));
        $I->submitForm($this->formId, []);

        $I->seeValidationError($I, \Yii::t('app/blog', 'title'));
        $I->seeValidationError($I, \Yii::t('app/blog', 'category_id'));
        $I->seeValidationError($I, \Yii::t('app/blog', 'content'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCreateNewPost(FunctionalTester $I): void
    {

        $I->wantTo('Create new post');

        $I->amLoggedInAs(\app\models\User::findByUsername('test'));
        $I->amOnPage('/post/create');
        $I->see(\Yii::t('app/blog', 'title_add_new_post'));
        $I->fillField(['name' => 'Post[title]'], 'Hello World');
        $I->selectOption(['name' => 'Post[category_id]'], '1');
        $I->fillField(['name' => 'Post[content]'], 'My first blog post added.');
        $I->click('#submit');

        $I->seeRecord('app\models\post\Post', [
            'title' => 'Hello World',
            'category_id' => '1',
            'content' => 'My first blog post added.'
        ]);
    }
}
