<?php

namespace app\tests\functional;

use FunctionalTester;
use app\tests\fixtures\UserFixture;

/**
 * Class SignupCest
 *
 * @package app\tests\functional
 */
class SignupCest
{
    protected $formId = '#form-signup';

    public function _before(FunctionalTester $I)
    {
        $I->haveFixtures([
            'user' => [
                'class' => UserFixture::class,
                'dataFile' => codecept_data_dir() . 'user.php',
            ]
        ]);

        $I->amOnRoute('site/signup');
    }

    public function signupWithEmptyFields(FunctionalTester $I)
    {
        $I->see(\Yii::t('app', 'signup_title'), 'h1');

        $I->submitForm($this->formId, []);

        $I->seeValidationError($I, \Yii::t('app', 'username'));
        $I->seeValidationError($I, \Yii::t('app', 'email'));
        $I->seeValidationError($I, \Yii::t('app', 'password'));
    }

    public function signupWithWrongEmail(FunctionalTester $I)
    {
        $I->submitForm(
            $this->formId, [
                'SignupForm[username]'  => 'tester',
                'SignupForm[email]'     => 'ttttt',
                'SignupForm[password]'  => 'tester_password',
            ]
        );

        $I->dontSeeValidationError($I, \Yii::t('app', 'username'));
        $I->dontSeeValidationError($I, \Yii::t('app', 'password'));
        $I->see(\Yii::t('app', 'email_is_not_valid_email'));
    }

    public function signupSuccessfully(FunctionalTester $I)
    {
        $I->submitForm($this->formId, [
            'SignupForm[username]' => 'tester',
            'SignupForm[email]' => 'tester@example.com',
            'SignupForm[password]' => 'tester_password',
            'SignupForm[captcha]' => 'test',
        ]);

        $I->seeRecord('app\models\User', [
            'username' => 'tester',
            'email' => 'tester@example.com',
            'status' => \app\models\User::STATUS_WAIT
        ]);
    }
}
