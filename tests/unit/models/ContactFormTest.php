<?php

namespace tests\models;

use app\models\ContactForm;

class ContactFormTest extends \Codeception\Test\Unit
{
    private $model;
    /**
     * @var \UnitTester
     */
    public $tester;

    public function testEmailIsSentOnContact()
    {
        /** @var ContactForm $model */
        $this->model = $this->getMockBuilder('app\models\ContactForm')->setMethods(['validate'])->getMock();

        $this->model->expects($this->once())->method('validate')->willReturn(true);

        $this->model->attributes = [
            'name' => 'Test',
            'email' => 'test@example.com',
            'subject' => 'Hello',
            'body' => 'Hello World!',
            'captcha' => 'test',
        ];

        expect_that($this->model->contact('admin@example.com'));

        // using Yii2 module actions to check email was sent
        $this->tester->seeEmailIsSent();

        $emailMessage = $this->tester->grabLastSentEmail();

        expect('valid email is sent', $emailMessage)->isInstanceOf('yii\mail\MessageInterface');
        expect($emailMessage->getTo())->hasKey('admin@example.com');
        expect($emailMessage->getFrom())->hasKey('no-reply@example.com');
        expect($emailMessage->getSubject())->equals('Hello');
        expect($emailMessage->toString())->stringContainsString('Hello World!');
    }
}
