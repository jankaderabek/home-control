<?php

namespace App\Presenters;

use App\Forms\Sign\Up\ISignUpFormFactory;
use App\Forms\Sign\In\ISignInFormFactory;
use Nette;


class SignPresenter extends Nette\Application\UI\Presenter
{
    /**
     * @var ISignInFormFactory
     */
    private $signInFormFactory;

    /**
     * @var ISignUpFormFactory
     */
    private $signUpFormFactory;

    public function __construct(
        ISignInFormFactory $signInFormFactory,
        ISignUpFormFactory $signUpFormFactory
    ) {
        parent::__construct();

        $this->signInFormFactory = $signInFormFactory;
        $this->signUpFormFactory = $signUpFormFactory;
    }

    public function createComponentSignInForm()
    {
        $signInForm = $this->signInFormFactory->create();

        $signInForm->setOnFormSuccess(function () {
            $this->flashMessage('Přihlášení proběhla úspěšně');
            $this->redirect('Homepage:');
        });

        return $signInForm;
    }

    public function createComponentSignUpForm()
    {
        $signUpForm = $this->signUpFormFactory->create();

        $signUpForm->setOnFormSuccess(function () {
            $this->flashMessage('Registrace proběhla úspěšně');
            $this->redirect('Sign:in');
        });

        return $signUpForm;
    }
}
