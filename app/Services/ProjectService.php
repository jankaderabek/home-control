<?php declare(strict_types=1);

namespace App\Services;

use App\Entities\Project;
use App\Entities\User;
use App\Exceptions\ProjectUserMustBeSpecifiedException;

class ProjectService
{
    public function createProject(string $token, string $name, ?User $user): Project
    {
        if (!$user) {
            throw new ProjectUserMustBeSpecifiedException('User not found');
        }

        return new Project($token, $name, $user);
    }

    public function canUserAccessProject(User $user, Project $project): bool
    {
        return $user->getId() === $project->getUser()->getId();
    }
}