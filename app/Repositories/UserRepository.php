<?php declare(strict_types = 1);

namespace App\Repositories;

use App\Entities\User;
use Doctrine\ORM\EntityManager;
use Kdyby\Doctrine\EntityRepository;

class UserRepository
{
    /**
     * @var EntityRepository
     */
    private $entityRepository;

    /**
     * @var EntityManager
     */
    private $entityManager;

    public function __construct(
        EntityManager $entityManager
    ) {
        $this->entityRepository = $entityManager->getRepository(User::class);
        $this->entityManager = $entityManager;
    }

    public function getEntityManager(): EntityManager
    {
        return $this->entityManager;
    }

    public function findByEmail(string $email): ?User
    {
        return $this->entityRepository->findOneBy(['email' => $email]);
    }

    public function findById(int $id): ?User
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }
}