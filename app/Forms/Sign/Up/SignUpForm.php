<?php declare(strict_types = 1);

namespace App\Forms\Sign\Up;

use App\Exceptions\UserAlreadyExistsException;
use App\Facades\UserFacade;
use Nette\Application\UI\Control;
use Nette\Application\UI\Form;

class SignUpForm extends Control
{
    private const PASSWORD_MIN_LENGTH = 7;

    /**
     * @var callable
     */
    private $onFormSuccess;

    /**
     * @var UserFacade
     */
    private $userFacade;

    public function __construct(UserFacade $userFacade)
    {
        parent::__construct();
        $this->userFacade = $userFacade;
    }

    public function createComponentForm()
    {
        $form = new Form();
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());

        $form->addText('email', 'E-mail')
            ->setType('email')
            ->addRule(Form::FILLED, "`%label` je povinný.")
            ->addRule(Form::EMAIL, '`%label` musí mít správný formát.');

        $form->addPassword('password', 'Password')
            ->setOption('description', sprintf('Heslo musí mít minimálně %d znaků', self::PASSWORD_MIN_LENGTH))
            ->setRequired('Zadejte heslo')
            ->addRule($form::MIN_LENGTH, NULL, self::PASSWORD_MIN_LENGTH);

        $form->addPassword('passwordVerify', 'Password2')
            ->setRequired('Zadejte heslo znovu pro potvrzení')
            ->addRule($form::EQUAL, 'Hesla se neshodují', $form['password']);

        $form->addSubmit('send');

        $form->onSuccess[] = [$this, 'onSuccess'];

        return $form;
    }

    public function onSuccess(Form $form, $values)
    {
        $user = null;

        try {
            $user = $this->userFacade->createUser($values->email, $values->password);
        } catch (UserAlreadyExistsException $exception) {
            $form->addError('Uživatel se zadaným e-mail již existuje.');
            //return;
        }

        ($this->onFormSuccess)();
    }

    public function setOnFormSuccess(callable $function)
    {
        $this->onFormSuccess = $function;
    }

    public function render()
    {
        $this->template->render(__DIR__ . '/SignUpForm.latte');
    }
}