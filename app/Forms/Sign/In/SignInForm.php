<?php declare(strict_types = 1);

namespace App\Forms\User;

use Nette\Application\UI\Control;
use Nette\Application\UI\Form;
use Nette;

class SignInForm extends Control
{
    /**
     * @var callable
     */
    private $onFormSuccess;

    /**
     * @var Nette\Security\User
     */
    private $user;

    public function __construct(Nette\Security\User $user)
    {
        parent::__construct();
        $this->user = $user;
    }

    public function createComponentForm()
    {
        $form = new Form();
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());

        $form->addText('email', 'E-mail')
            ->setRequired('Zadejte prosím e-mail.');

        $form->addPassword('password', 'Password')
            ->setRequired('Zadejte heslo k přihlášení.');

        $form->addCheckbox('remember', 'Zapamatovat');
        $form->addSubmit('send');

        $form->onSuccess[] = [$this, 'onSuccess'];

        return $form;
    }

    public function onSuccess(Form $form, $values)
    {
        try {
            $this->user->setExpiration($values->remember ? '14 days' : '20 minutes');
            $this->user->login($values->email, $values->password);
        } catch (Nette\Security\AuthenticationException $e) {
            $form->addError('Chybný uživatelský e-mail nebo heslo.');
            return;
        }

        ($this->onFormSuccess)();
    }

    public function setOnFormSuccess(callable $function)
    {
        $this->onFormSuccess = $function;
    }

    public function render()
    {
        $this->template->render(__DIR__ . '/SignInForm.latte');
    }
}