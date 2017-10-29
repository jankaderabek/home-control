<?php

namespace Tests\Unit\Model;

use App\Entities\Sensor;
use App\Exceptions\CannotGenerateNewSensorToken;
use App\Model\SensorTokenGenerator;
use App\Repositories\SensorRepository;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

/**
 * @testCase
 */
class SensorTokenGeneratorTest extends TestCase
{
    public function testGenerateNewSensorToken()
    {
        $sensorService = \Mockery::mock(SensorRepository::class);
        $sensorService
            ->shouldReceive('findByTokenAndProject')
            ->andReturn(null);

        $sensorTokenGenerator = new SensorTokenGenerator($sensorService);
        $token = $sensorTokenGenerator->generate(1);

        Assert::type('string', $token);
        Assert::equal(5, strlen($token));
    }

    public function testGenerateExistingToken()
    {
        $sensorService = \Mockery::mock(SensorRepository::class);
        $sensorService
            ->shouldReceive('findByTokenAndProject')
            ->andReturn(\Mockery::mock(Sensor::class));

        Assert::throws(function () use ($sensorService) {
            $sensorTokenGenerator = new SensorTokenGenerator($sensorService);
            $sensorTokenGenerator->generate(1);
        },
            CannotGenerateNewSensorToken::class
        );
    }
}


(new SensorTokenGeneratorTest())->run();
