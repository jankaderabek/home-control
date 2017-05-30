<?php declare(strict_types=1);

namespace App\Facades;

use App\Entities\Project;
use App\Repositories\ProjectRepository;
use App\Repositories\UserRepository;
use App\Services\ProjectService;
use App\Services\ProjectTokenService;
use Doctrine\ORM\EntityManager;

class ProjectFacade
{
    /**
     * @var EntityManager
     */
    private $entityManager;

    /**
     * @var ProjectTokenService
     */
    private $projectTokenService;

    /**
     * @var ProjectRepository
     */
    private $projectRepository;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var ProjectService
     */
    private $projectService;

    public function __construct(
        EntityManager $entityManager,
        ProjectTokenService $projectTokenService,
        ProjectRepository $projectRepository,
        UserRepository $userRepository,
        ProjectService $projectService
    ) {
        $this->entityManager = $entityManager;
        $this->projectTokenService = $projectTokenService;
        $this->projectRepository = $projectRepository;
        $this->userRepository = $userRepository;
        $this->projectService = $projectService;
    }

    public function createProject(string $name, int $userId): Project
    {
        $token = $this->projectTokenService->getNew();
        $user = $this->userRepository->findById($userId);
        $project = $this->projectService->createProject($token, $name, $user);

        $this->entityManager->persist($project);
        $this->entityManager->flush();

        return $project;
    }

    public function editProject(int $projectId, string $name): Project
    {
        $project = $this->projectRepository->findById($projectId);
        $project->setName($name);

        $this->entityManager->flush();

        return $project;
    }
}