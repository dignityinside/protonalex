<?php

namespace app\tests\models;

use app\models\User;
use app\tests\fixtures\UserFixture;

/**
 * Class UserTest
 *
 * @package app\tests\models
 */
class UserTest extends \Codeception\Test\Unit
{

    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ],
        ];
    }

    public function testFindUserById()
    {
        expect_that($user = User::findIdentity(1));
        expect($user->username)->equals('test');
    }

    public function testFindUserByUsername()
    {
        expect_that($user = User::findByUsername('test'));
    }

    /**
     * @depends testFindUserByUsername
     */
    public function testValidateUser()
    {
        $user = User::findByUsername('test2');

        expect($user->username)->equals('test2');
        expect($user->status)->equals('10');
        expect($user->email)->equals('test2@example.com');
        expect($user->created_at)->equals('1548675330');
        expect($user->updated_at)->equals('1548675330');

        expect_that($user->validateAuthKey('O87GkY3_UfmMHYkyezZ7QLfmkKNsllzT'));
        expect_that($user->validatePassword('Test1234'));
    }

    /**
     * @depends testValidateUser
     */
    public function testValidateNotPremiumUser()
    {
        $user = User::findByUsername('test');
        expect($user->premium)->equals('0');
    }

    /**
     * @depends testValidateUser
     */
    public function testValidatePremiumUser()
    {
        $user = User::findByUsername('test2');
        expect($user->premium)->equals('1');
    }
}
