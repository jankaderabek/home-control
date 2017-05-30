<?php

namespace Tests\Unit\Services;

use App\Entities\Project;
use App\Entities\User;
use App\Exceptions\ProjectUserMustBeSpecifiedException;
use App\Services\ProjectService;
use Tester\Assert;
use Tester\TestCase;

require_once __DIR__ . '/../../../bootstrap.php';

class ProjectServiceTest extends TestCase
{
    public function testCreateProject()
    {
        $projectService = new ProjectService();
        $user = new User('test@email.com', 'Heslo123');

        $project = $projectService->createProject('token', 'nazev', $user);

        Assert::type(Project::class, $project);
        Assert::equal($user, $project->getUser());
    }

    public function testCreateProjectWithoutUser()
    {
        Assert::throws(function () {
                $projectService = new ProjectService();
                $projectService->createProject('token', 'nazev', null);
            },
            ProjectUserMustBeSpecifiedException::class
        );
    }
}

(new ProjectServiceTest())->run();
