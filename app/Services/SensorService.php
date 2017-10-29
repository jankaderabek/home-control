<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\Project;
use App\Entities\Sensor;
use App\Exceptions\SensorProjectMustBeSpecified;

class SensorService
{
    public function createSensor(string $name, string $identifier, ?Project $project): Sensor
    {
        if (!$project) {
            throw new SensorProjectMustBeSpecified();
        }

        return new Sensor($identifier, $name, $project);
    }
}