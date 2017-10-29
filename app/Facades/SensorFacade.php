<?php declare(strict_types=1);

namespace App\Facades;

use App\Entities\Sensor;
use App\Model\SensorTokenGenerator;
use App\Repositories\ProjectRepository;
use App\Services\SensorService;

class SensorFacade
{
    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var SensorTokenGenerator
     */
    private $sensorTokenGenerator;

    /**
     * @var SensorService
     */
    private $sensorService;

    public function __construct(
        ProjectRepository $projectRepository,
        SensorTokenGenerator $sensorTokenGenerator,
        SensorService $sensorService
    ) {
        $this->projectRepository = $projectRepository;
        $this->sensorTokenGenerator = $sensorTokenGenerator;
        $this->sensorService = $sensorService;
    }

    public function createSensor(string $name, int $projectId): Sensor
    {
        $project = $this->projectRepository->findById($projectId);
        $token = $this->sensorTokenGenerator->generate($projectId);

        return $this->sensorService->createSensor($name, $token, $project);
    }
}