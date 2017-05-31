<?php

namespace Tests\Integration\Project;

use App\Entities\User;
use App\Facades\ProjectFacade;
use Doctrine\ORM\EntityManager;
use Tester\Assert;
use Tests\Integration\IntegrationTestCase;

require_once '../../bootstrap.php';

class ProjectFacadeTest extends IntegrationTestCase
{
    public function testCreateNewProject()
    {
        $user = new User('email', 'password');

        /** @var EntityManager $entityManager */
        $entityManager = $this->getContainer()->getByType(EntityManager::class);

        $entityManager->persist($user);
        $entityManager->flush();

        /** @var ProjectFacade $projectFacade */
        $projectFacade = $this->getContainer()->getByType(ProjectFacade::class);
        $project = $projectFacade->createProject("novy", $user->getId());

        Assert::true($project->getId() != null);
        Assert::equal($user, $project->getUser());
    }
}

(new ProjectFacadeTest())->run();