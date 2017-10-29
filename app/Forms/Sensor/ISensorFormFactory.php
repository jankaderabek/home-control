<?php

namespace App\Forms\Sensor;


use App\Entities\Project;
use App\Entities\Sensor;

interface ISensorFormFactory
{
    public function create(?Project $project, ?Sensor $sensor = null): SensorForm;
}
