<?php declare(strict_types = 1);

namespace App\Forms\Project;

use App\Entities\Project;

interface IProjectFormFactory
{
    public function create(?Project $project): ProjectForm;
}