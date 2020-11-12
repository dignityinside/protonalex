<?php

namespace app\tests\unit\models;

use app\tests\fixtures\UserFixture;
use app\models\ResetPasswordForm;

/**
 * Class ResetPasswordFormTest
 *
 * @package app\tests\unit\models
 */
class ResetPasswordFormTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;

    public function _before()
    {
        $this->tester->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php'
            ],
        ]);
    }

    public function testResetWrongToken()
    {
        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('');
        });

        $this->tester->expectThrowable('\yii\base\InvalidArgumentException', function() {
            new ResetPasswordForm('notexistingtoken_1391882543');
        });
    }

    public function testResetCorrectToken()
    {
        $user = $this->tester->grabFixture('user', 0);
        $form = new ResetPasswordForm($user['password_reset_token']);
        expect_that($form->resetPassword());
    }
}
