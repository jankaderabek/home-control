<?php declare(strict_types = 1);

namespace App\Forms\User;

use App\Entities\Project;
use App\Exceptions\CannotGenerateNewProjectToken;
use App\Facades\ProjectFacade;
use App\Forms\BaseForm;
use Nette\Application\UI\Form;
use Nette;

class ProjectForm extends BaseForm
{
    /**
     * @var callable
     */
    private $onFormSuccess;

    /**
     * @var ProjectFacade
     */
    private $projectFacade;

    /**
     * @var Nette\Security\User
     */
    private $user;

    /**
     * @var Project|null
     */
    private $project;

    public function __construct(
        ?Project $project,
        ProjectFacade $projectFacade,
        Nette\Security\User $user
    ) {
        parent::__construct();

        $this->projectFacade = $projectFacade;
        $this->user = $user;
        $this->project = $project;
    }

    public function createComponentForm()
    {
        $form = new Form();
        $form->setRenderer(new \Nextras\Forms\Rendering\Bs3FormRenderer());

        $form->addHidden('id');

        $form->addText('name', 'Název')
            ->setRequired('Zadejte prosím název.');

        $form->addSubmit('send', 'Uložit');

        $form->onSuccess[] = [$this, 'onSuccess'];

        return $form;
    }

    public function onSuccess(Form $form, $values)
    {
        $project = $this->processForm($form, $values);

        if ($project) {
            ($this->onFormSuccess)($project);
        }
    }

    public function setOnFormSuccess(callable $function)
    {
        $this->onFormSuccess = $function;
    }

    public function render()
    {
        $this->getTemplate()->render(__DIR__ . '/ProjectForm.latte');
    }

    private function processForm(Form $form, $values): ?Project
    {
        if (!empty($values->id)) {
            return $this->projectFacade->editProject((int)$values->id, $values->name);
        }

        try {
            return $this->projectFacade->createProject($values->name, $this->user->getId());
        } catch (CannotGenerateNewProjectToken $e) {
            $form->addError('Chybný uživatelský e-mail nebo heslo.');
        }

        return null;
    }
}