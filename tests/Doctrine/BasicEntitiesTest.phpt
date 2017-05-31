<?php

namespace Tests\Doctrine;

use App\Entities\Project;
use App\Entities\Sensor;
use App\Entities\User;
use App\Entities\Value;
use Doctrine\ORM\EntityManager;
use Tester\Assert;
use Tests\Integration\IntegrationTestCase;

require_once __DIR__ . '/../bootstrap.php';

class DoctrineBasicEntitiesTest extends IntegrationTestCase
{
    public function testEntities()
    {
        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->getByType(EntityManager::class);
        Assert::true($entityManager instanceof EntityManager);
        Assert::true(true);

        $value = new Value(
            25.5,
            new Sensor(
                "srgr",
                "Muj senzor",
                new Project(
                    "fsgr",
                    "Muj projekt",
                    new User(
                        'email',
                        'password')
                )
            )
        );

        $entityManager->persist($value);
        $entityManager->flush();

        $savedValues = $entityManager->getRepository(Value::class)->findAll();

        Assert::equal(1, count($savedValues));
        /** @var Value $savedValue */
        $savedValue = $savedValues[0];

        Assert::equal("Muj senzor", $savedValue->getSensor()->getName());
        Assert::equal("Muj projekt", $savedValue->getSensor()->getProject()->getName());
    }
}

(new DoctrineBasicEntitiesTest())->run();