<?php


namespace App\Services;

use App\Models\Project;
use App\Models\User;

class ProjectService
{
    public function createProjectsForUser(User $user): void
    {
        $count = rand(config('seeder.min_count'), config('seeder.max_count'));
        $projects = Project::factory($count)->make();
        $user->projects()->saveMany($projects);
    }
}

