<?php declare(strict_types=1);

namespace App\Presenters;

use App\Entities\Project;
use App\Forms\User\IProjectFormFactory;
use App\Forms\User\ProjectForm;
use App\Repositories\ProjectRepository;
use App\Services\ProjectService;
use Nette\Http\IResponse;

class ProjectPresenter extends SecuredPresenter
{
    /**
     * @var Project|null
     */
    private $editingProject;

    /**
     * @var IProjectFormFactory
     */
    private $projectFormFactory;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var ProjectService
     */
    private $projectService;

    public function __construct(
        IProjectFormFactory $projectFormFactory,
        ProjectRepository $projectRepository,
        ProjectService $projectService
    ) {
        parent::__construct();
        $this->projectFormFactory = $projectFormFactory;
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
    }

    public function renderDetail($id)
    {
        $project = $this->projectRepository->findById((int)$id);

        if (!$project) {
            $this->error('Neexistující projekt');
        }

        if (!$this->projectService->canUserAccessProject($this->getApplicationUser(), $project)) {
            $this->error("Nemáte oprávnění", IResponse::S403_FORBIDDEN);
        }

        $this->getTemplate()->add('project', $project);
    }

    public function actionEdit($id)
    {
        $this->editingProject = $this->projectRepository->findById((int)$id);

        if (!$this->editingProject) {
            $this->error('Neexistující projekt');
        }

        if (!$this->projectService->canUserAccessProject($this->getApplicationUser(), $this->editingProject)) {
            $this->error("Nemáte oprávnění", IResponse::S403_FORBIDDEN);
        }
    }

    public function createComponentProjectForm(): ProjectForm
    {
        $projectForm = $this->projectFormFactory->create($this->editingProject);

        $projectForm->setOnFormSuccess(function (Project $project) {
           $this->redirect(':Project:detail', ['id' => $project->getId()]);
        });

        return $projectForm;
    }
}