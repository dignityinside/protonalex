<?php

use app\tests\fixtures\CategoryFixture;
use app\tests\fixtures\PostFixture;
use app\tests\fixtures\UserFixture;

class PostAdminCest
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

        $I->amLoggedInAs(\app\models\User::findByUsername('test'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryOpenPostAdminPage(FunctionalTester $I): void
    {
        $I->wantTo('Open post admin page');

        $I->amOnPage('/post/admin');
        $I->see(\Yii::t('app/blog', 'posts'));
        $I->see(\Yii::t('app/blog', 'button_add_new_post'));
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryCreatePostWithEmptyField(FunctionalTester $I): void
    {
        $I->wantTo('Create new post, with empty fields');

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

        $I->amOnPage('/post/create');
        $I->see(\Yii::t('app/blog', 'title_add_new_post'));
        $I->fillField(['name' => 'Post[title]'], 'Hello World');
        $I->selectOption(['name' => 'Post[category_id]'], '1');
        $I->fillField(['name' => 'Post[content]'], 'My first blog post added.');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'title' => 'Hello World',
            'category_id' => '1',
            'content' => 'My first blog post added.'
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryUpdatePost(FunctionalTester $I): void
    {

        $I->wantTo('Update existing post');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->fillField(['name' => 'Post[title]'], 'Hello World edited');
        $I->selectOption(['name' => 'Post[category_id]'], '1');
        $I->fillField(['name' => 'Post[content]'], 'My first blog post edited.');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'title' => 'Hello World edited',
            'category_id' => '1',
            'content' => 'My first blog post edited.'
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostTitle(FunctionalTester $I): void
    {

        $I->wantTo('Change post title');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->fillField(['name' => 'Post[title]'], 'Hello World edited');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'title' => 'Hello World edited',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostSlug(FunctionalTester $I): void
    {

        $I->wantTo('Change post slug');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->fillField(['name' => 'Post[slug]'], 'hello-world-edited');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'slug' => 'hello-world-edited',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostCategory(FunctionalTester $I): void
    {

        $I->wantTo('Change post category');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[category_id]'], '2');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'category_id' => '2',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostToPremium(FunctionalTester $I): void
    {

        $I->wantTo('Change post to premium post');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[premium]'], '1');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'premium' => '1',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostToNonPremium(FunctionalTester $I): void
    {

        $I->wantTo('Change post to non premium post');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[premium]'], '0');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'premium' => '0',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostMetaDescription(FunctionalTester $I): void
    {

        $I->wantTo('Change post meta description');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->fillField(['name' => 'Post[meta_description]'], 'hello world meta description');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'meta_description' => 'hello world meta description',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostContent(FunctionalTester $I): void
    {

        $I->wantTo('Change post content');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->fillField(['name' => 'Post[content]'], 'This is my new content.');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'content' => 'This is my new content.',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostToPublic(FunctionalTester $I): void
    {

        $I->wantTo('Change post to public status');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[status_id]'], '1');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'status_id' => '1',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostToDraft(FunctionalTester $I): void
    {

        $I->wantTo('Change post to draft status');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[status_id]'], '0');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'status_id' => '0',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostAllowComments(FunctionalTester $I): void
    {

        $I->wantTo('Change post allow comments');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[allow_comments]'], '1');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'allow_comments' => '1',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostDisallowComments(FunctionalTester $I): void
    {

        $I->wantTo('Change post disallow comments');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[allow_comments]'], '0');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'allow_comments' => '0',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostShowOnTop(FunctionalTester $I): void
    {

        $I->wantTo('Change post show on top');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[ontop]'], '1');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'ontop' => '1',
        ]);
    }

    /**
     * @param FunctionalTester $I
     */
    public function tryChangePostNonShowOnTop(FunctionalTester $I): void
    {

        $I->wantTo('Change post non show on top');

        $I->amOnPage('/post/update/1');
        $I->see(\Yii::t('app/blog', 'title_update_post'));
        $I->selectOption(['name' => 'Post[ontop]'], '0');
        $I->click('.btn');

        $I->seeRecord('app\models\post\Post', [
            'ontop' => '0',
        ]);
    }
}
