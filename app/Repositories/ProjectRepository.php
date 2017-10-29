<?php declare(strict_types=1);

namespace App\Repositories;

use App\Entities\Project;
use App\Entities\User;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\EntityManager;
use Kdyby\Doctrine\EntityRepository;

class ProjectRepository
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityRepository = $entityManager->getRepository(Project::class);
        $this->entityManager = $entityManager;
    }

    public function findByToken(string $token): ?Project
    {
        return $this->entityRepository->findOneBy(['token' => $token]);
    }

    public function findById(int $id): ?Project
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }

    public function findAllUserProjects(User $user ): array
    {
        return $this->entityRepository->findBy(['user' => $user]);
    }
}
