<?php

namespace app\tests\functional;

use FunctionalTester;
use app\tests\fixtures\UserFixture;

/**
 * Class LoginCest
 *
 * @package app\tests\functional
 */
class LoginCest
{
    /**
     * Load fixtures before db transaction begin
     * Called in _before()
     * @see \Codeception\Module\Yii2::_before()
     * @see \Codeception\Module\Yii2::loadFixtures()
     *
     * @return array
     */
    public function _fixtures()
    {
        return [
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'login_data.php',
            ],
        ];
    }

    public function _before(FunctionalTester $I)
    {
        $I->amOnRoute('site/login');
    }

    protected function formParams($login, $password)
    {
        return [
            'LoginForm[username]' => $login,
            'LoginForm[password]' => $password,
        ];
    }

    public function checkEmpty(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('', ''));

        $I->seeValidationError($I, \Yii::t('app', 'username'));
        $I->seeValidationError($I, \Yii::t('app', 'password'));
    }

    public function checkWrongPassword(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('test', 'wrong'));
        $I->see(\Yii::t('app', 'invalid_login_password'));

    }

    public function checkDeletedAccount(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('test.deleted', 'Test1234'));
        $I->see(\Yii::t('app', 'invalid_login_password'));
    }

    public function checkValidLogin(FunctionalTester $I)
    {
        $I->submitForm('#login-form', $this->formParams('test', 'password_0'));
        $I->dontSeeLink(\Yii::t('app', 'menu_label_login'));
    }
}