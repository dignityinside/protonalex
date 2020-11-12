<?php

namespace app\tests\functional;

use FunctionalTester;

/**
 * Class ContactFormCest
 *
 * @package app\tests\functional
 */
class ContactFormCest
{
    public function _before(FunctionalTester $I)
    {
        $I->amOnPage(['site/contact']);
    }

    public function openContactPage(FunctionalTester $I)
    {
        $I->see(\Yii::t('app', 'contact_title'), 'h1');
    }

    public function submitEmptyForm(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', []);

        $I->expectTo('see validations errors');

        $I->see(\Yii::t('app', 'contact_title'), 'h1');

        $I->seeValidationError($I, \Yii::t('app', 'contact_name'));
        $I->seeValidationError($I, \Yii::t('app', 'contact_email'));
        $I->seeValidationError($I, \Yii::t('app', 'contact_subject'));
        $I->seeValidationError($I, \Yii::t('app', 'contact_body'));
        $I->seeValidationError($I, \Yii::t('app', 'captcha'));
    }

    public function submitFormWithIncorrectEmail(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[captcha]' => 'test',
        ]);

        $I->expectTo('see that email address is wrong');

        $I->see(\Yii::t('app', 'email_is_not_valid_email'));

        $I->dontSeeValidationError($I, \Yii::t('app', 'contact_name'));
        $I->dontSeeValidationError($I, \Yii::t('app', 'contact_subject'));
        $I->dontSeeValidationError($I, \Yii::t('app', 'contact_body'));
        $I->dontSeeValidationError($I, \Yii::t('app', 'captcha'));
    }

    public function submitFormSuccessfully(FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester@example.com',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[captcha]' => 'test',
        ]);
        $I->seeEmailIsSent();
        $I->dontSeeElement('#contact-form');
        $I->see(\Yii::t('app', 'contact_email_send'));
    }
}
