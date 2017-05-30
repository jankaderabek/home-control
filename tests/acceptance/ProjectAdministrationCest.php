<?php

require_once 'LoggedUser.php';

class ProjectAdministrationCest extends LoggedUser
{
    public function tryToCreateProject(AcceptanceTester $I)
    {
        $I->amOnPage('/project/add');
        $I->amGoingTo('Crete new project');

        $I->fillField('Název', 'Novy projekt');
        $I->click('send');

        $I->canSeeInCurrentUrl('/project/detail');
        $I->see('Novy projekt');
    }
}
