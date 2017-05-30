<?php


class UserAuthenticationCest
{
    public function tryToSignUpAndSignIn(AcceptanceTester $I)
    {
        $I->amOnPage('/sign/up');
        $I->amGoingTo('Crete new account');

        $I->fillField('E-mail', 'test@email.cz');
        $I->fillField('Password', 'Heslo123');
        $I->fillField('Password2', 'Heslo123');
        $I->click('send');

        $I->canSeeInCurrentUrl('/sign/in');

        $I->amGoingTo('Log in');
        $I->fillField('E-mail', 'test@email.cz');
        $I->fillField('Password', 'Heslo123');
        $I->click('send');

        $I->see('Přihlášení proběhla úspěšně');
        $I->dontSeeInCurrentUrl('/sign/in');
    }

    public function tryToSignUpWithExistingMail(AcceptanceTester $I)
    {
        $I->amOnPage('/sign/up');
        $I->amGoingTo('Crete new account');

        $I->fillField('E-mail', 'test@email.cz');
        $I->fillField('Password', 'Heslo123');
        $I->fillField('Password2', 'Heslo123');
        $I->click('send');

        $I->canSeeInCurrentUrl('/sign/in');

        $I->amOnPage('/sign/up');
        $I->amGoingTo('Crete new account');

        $I->fillField('E-mail', 'test@email.cz');
        $I->fillField('Password', 'Heslo123');
        $I->fillField('Password2', 'Heslo123');
        $I->click('send');

        $I->see('Uživatel se zadaným e-mail již existuje.');
    }

    public function tryToSignInWithIncorrectEmail(AcceptanceTester $I)
    {
        $I->amOnPage('/sign/in');

        $I->amGoingTo('Log in');
        $I->fillField('E-mail', 'unknown@email.cz');
        $I->fillField('Password', 'Heslo123');
        $I->click('send');

        $I->see('Chybný uživatelský e-mail nebo heslo.');
        $I->seeInCurrentUrl('/sign/in');
    }

    public function tryToSignInWithIncorrectPassword(AcceptanceTester $I)
    {
        $I->amOnPage('/sign/in');

        $I->amGoingTo('Log in');
        $I->fillField('E-mail', 'test@email.cz');
        $I->fillField('Password', 'Heslo13');
        $I->click('send');

        $I->see('Chybný uživatelský e-mail nebo heslo.');
        $I->seeInCurrentUrl('/sign/in');
    }
}
