<?php

class ContactFormCest
{
    public function _before(\FunctionalTester $I)
    {
        $I->amOnPage(['site/contact']);
    }

    public function openContactPage(\FunctionalTester $I)
    {
        $I->see(\Yii::t('app', 'contact_title'), 'h1');
    }

    public function submitEmptyForm(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', []);

        $I->expectTo('see validations errors');

        $I->see(\Yii::t('app', 'contact_title'), 'h1');

        $I->see(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_name'),
        ]));

        $I->see(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_email'),
        ]));

        $I->see(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_subject'),
        ]));

        $I->see(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_body'),
        ]));

        $I->see(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_captcha'),
        ]));
    }

    public function submitFormWithIncorrectEmail(\FunctionalTester $I)
    {
        $I->submitForm('#contact-form', [
            'ContactForm[name]' => 'tester',
            'ContactForm[email]' => 'tester.email',
            'ContactForm[subject]' => 'test subject',
            'ContactForm[body]' => 'test content',
            'ContactForm[captcha]' => 'test',
        ]);

        $I->expectTo('see that email address is wrong');

        $I->dontSee(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_name'),
        ]));

        $I->see(\Yii::t('app', 'email_is_not_valid_email'));

        $I->dontSee(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_subject'),
        ]));

        $I->dontSee(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_body'),
        ]));

        $I->dontSee(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => \Yii::t('app', 'contact_captcha'),
        ]));
    }

    public function submitFormSuccessfully(\FunctionalTester $I)
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
