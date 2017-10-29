<?php

namespace Tests\Unit\Services;

use App\Entities\Project;
use App\Entities\Sensor;
use App\Entities\User;
use App\Services\SensorService;
use App\Exceptions\SensorProjectMustBeSpecified;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class SensorServiceTest extends TestCase
{
    public function testCreateSensor()
    {
        $projectService = new SensorService();

        $user = new User('email', 'heslo');
        $project = new Project('token', 'name', $user);
        $sensor = $projectService->createSensor('sensorName', 'sensorIdentifier', $project);

        Assert::type(Sensor::class, $sensor);
        Assert::equal('sensorName', $sensor->getName());
        Assert::equal('sensorIdentifier', $sensor->getIdentifier());
        Assert::equal($project, $sensor->getProject());
    }

    public function testCreateProjectWithoutUser()
    {
        Assert::throws(function () {
                $sensorService = new SensorService();
                $sensorService->createSensor('sensor', 'identifier', null);
            },
            SensorProjectMustBeSpecified::class
        );
    }
}

(new SensorServiceTest())->run();
