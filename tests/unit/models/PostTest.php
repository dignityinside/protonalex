<?php

namespace app\tests\models;

use app\models\post\Post;
use app\tests\fixtures\PostFixture;
use app\tests\fixtures\UserFixture;

/**
 * Class PostTest
 *
 * @package app\tests\models
 */
class PostTest extends \Codeception\Test\Unit
{

    public function _fixtures()
    {
        return [
            'users' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
            'post' => [
                'class' => PostFixture::class,
                'dataFile' => codecept_data_dir() . 'post.php',
            ],
        ];
    }

    public function testValidatePost()
    {
        $post = Post::find()->where(['id' => 1])->one();;

        expect($post->title)->equals('Hello world!');
        expect($post->content)->equals('My first blog post.');
        expect($post->allow_comments)->equals('1');
        expect($post->status_id)->equals('0');
        expect($post->ontop)->equals('1');
        expect($post->meta_description)->equals('Hello World meta description');
        expect($post->slug)->equals('hello-world');
        expect($post->category_id)->equals('1');
        expect($post->premium)->equals('0');
        expect($post->datecreate)->equals(time());
    }

    /**
     * @depends testValidatePost
     */
    public function testValidatePremiumPost()
    {
        $post = Post::find()->where(['id' => 2])->one();
        expect($post->premium)->equals('1');
    }

    /**
     * @depends testValidatePost
     */
    public function testValidateDraftPost()
    {
        $post = Post::find()->where(['id' => 1])->one();
        expect($post->status_id)->equals('0');
    }

    /**
     * @depends testValidatePost
     */
    public function testValidatePublicPost()
    {
        $post = Post::find()->where(['id' => 2])->one();
        expect($post->status_id)->equals('1');
    }

    /**
     * @depends testValidatePost
     */
    public function testPostCommentsAllowed()
    {
        $post = Post::find()->where(['id' => 1])->one();
        expect($post->commentsAllowed())->true();
    }
}
