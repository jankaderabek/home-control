<?php declare(strict_types=1);

namespace App\Services;

use App\Exceptions\CannotGenerateNewProjectToken;
use App\Repositories\ProjectRepository;
use Nette\Utils\Random;

class ProjectTokenService
{
    private const MAXIMUM_ATTEMPTS = 5;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    public function __construct(
        ProjectRepository $projectRepository
    ) {
        $this->projectRepository = $projectRepository;
    }

    public function getNew(): string
    {
        $attempts = 0;

        do {
            $token = Random::generate();
            $project = $this->projectRepository->findByToken($token);
            $attempts += 1;
        }
        while ($project && $attempts < self::MAXIMUM_ATTEMPTS);

        if ($project) {
            throw new CannotGenerateNewProjectToken();
        }

        return $token;
    }
}