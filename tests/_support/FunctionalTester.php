<?php

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
 */
class FunctionalTester extends \Codeception\Actor
{
    use _generated\FunctionalTesterActions;

    /**
     * @param FunctionalTester $I
     * @param string $field
     */
    public function seeValidationError(\FunctionalTester $I, string $field)
    {
        $I->see(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => $field,
        ]));
    }

    /**
     * @param FunctionalTester $I
     * @param string $field
     */
    public function dontSeeValidationError(\FunctionalTester $I, string $field)
    {
        $I->dontSee(\Yii::t('app', '{field}_cannot_be_blank', [
            'field' => $field,
        ]));
    }
}
