<?php declare(strict_types = 1);

namespace App\Forms\User;

use App\Entities\Project;

interface IProjectFormFactory
{
    public function create(?Project $project): ProjectForm;
}