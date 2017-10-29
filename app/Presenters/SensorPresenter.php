<?php declare(strict_types=1);


namespace App\Presenters;

use App\Entities\Project;
use App\Entities\Sensor;
use App\Forms\Sensor\ISensorFormFactory;
use App\Forms\Sensor\SensorForm;
use App\Repositories\ProjectRepository;
use App\Repositories\SensorRepository;
use App\Services\ProjectService;
use Nette\Http\IResponse;

class SensorPresenter extends SecuredPresenter
{
    /**
     * @var Project
     */
    private $project;

    /**
     * @var Sensor
     */
    private $sensor;

    /**
     * @var ISensorFormFactory
     */
    private $sensorFormFactory;

    /**
     * @var SensorRepository
     */
    private $sensorRepository;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var ProjectService
     */
    private $projectService;

    public function __construct(
        ISensorFormFactory $sensorFormFactory,
        SensorRepository $sensorRepository,
        ProjectRepository $projectRepository,
        ProjectService $projectService
    ) {
        parent::__construct();

        $this->sensorFormFactory = $sensorFormFactory;
        $this->sensorRepository = $sensorRepository;
        $this->projectRepository = $projectRepository;
        $this->projectService = $projectService;
    }

    public function renderDetail($id)
    {
        $sensor = $this->sensorRepository->findById((int) $id);

        if (!$sensor) {
            $this->error('Neexistující sensor');
        }

        if (!$this->projectService->canUserAccessProject($this->getApplicationUser(), $sensor)) {
            $this->error("Nemáte oprávnění", IResponse::S403_FORBIDDEN);
        }

        $this->getTemplate()->add('sensor', $sensor);
    }

    public function actionAdd(int $id): void
    {
        $this->project = $this->projectRepository->findById((int) $id);

        if ( ! $this->project) {
            $this->error('Neexistující projekt');
        }

        if ( ! $this->projectService->canUserAccessProject($this->getApplicationUser(), $this->project)) {
            $this->error("Nemáte oprávnění", IResponse::S403_FORBIDDEN);
        }
    }

    public function actionEdit(int $id): void
    {
        $this->sensor = $this->sensorRepository->findById((int) $id);

        if ( ! $this->sensor) {
            $this->error('Neexistující sensor');
        }

        if ( ! $this->projectService->canUserAccessProject($this->getApplicationUser(), $this->sensor->getProject())) {
            $this->error("Nemáte oprávnění", IResponse::S403_FORBIDDEN);
        }
    }

    public function createComponentSensorForm(): SensorForm
    {
        $sensorForm = $this->sensorFormFactory->create($this->project, $this->sensor);

        $sensorForm->setOnFormSuccess(function (Sensor $sensor) {
            $this->redirect(':Sensor:detail', ['id' => $sensor->getId()]);
        });

        return $sensorForm;
    }
}
