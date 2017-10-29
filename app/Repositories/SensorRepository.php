<?php declare(strict_types=1);


namespace App\Repositories;

use App\Entities\Sensor;
use Kdyby\Doctrine\EntityManager;
use Kdyby\Doctrine\EntityRepository;

class SensorRepository
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
        $this->entityRepository = $entityManager->getRepository(Sensor::class);
        $this->entityManager = $entityManager;
    }

    public function findById(int $id): ?Sensor
    {
        return $this->entityRepository->findOneBy(['id' => $id]);
    }

    public function findByTokenAndProject(string $token, int $projectId): ?Sensor
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder
            ->select('s')
            ->from('Sensor', 's')
            ->where('s.identifier = :identifier')
            ->andWhere('s.project.id = :projectId')
            ->setParameter('identifier', $token)
            ->setParameter('projectId', $projectId);

        return $queryBuilder->getQuery()->getSingleResult();
    }
}