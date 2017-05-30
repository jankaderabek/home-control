<?php

abstract class LoggedUser
{
    public function _before(AcceptanceTester $I)
    {
        $I->amGoingTo('Log in');
        $I->amOnPage('/sign/in');

        $I->fillField('E-mail', 'testuser@mail.com');
        $I->fillField('Password', 'Heslo123');
        $I->click('send');

        $I->see('Přihlášení proběhla úspěšně');
        $I->dontSeeInCurrentUrl('/sign/in');
    }
}
