<?php declare(strict_types=1);

namespace App\Model;

use App\Exceptions\CannotGenerateNewSensorToken;
use App\Repositories\SensorRepository;
use Nette\Utils\Random;

class SensorTokenGenerator
{
    private const MAXIMUM_ATTEMPTS = 5;
    private const TOKEN_LENGTH = 5;

    /**
     * @var SensorRepository
     */
    private $sensorRepository;

    public function __construct(SensorRepository $sensorRepository)
    {
        $this->sensorRepository = $sensorRepository;
    }

    public function generate(int $projectId): string
    {
        $attempts = 0;

        do {
            $token = Random::generate(self::TOKEN_LENGTH);
            $sensor = $this->sensorRepository->findByTokenAndProject($token, $projectId);
            $attempts += 1;
        }
        while ($sensor && $attempts < self::MAXIMUM_ATTEMPTS);

        if ($sensor) {
            throw new CannotGenerateNewSensorToken();
        }

        return $token;
    }
}