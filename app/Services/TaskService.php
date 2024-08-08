<?php

namespace App\Services;

use App\Models\Task;

class TaskService
{
    public function createTasksForProjects($projects): void
    {
        $projects->each(function ($project) {
            $count = rand(config('seeder.min_count'), config('seeder.max_count'));
            $tasks = Task::factory($count)->make();
            $project->tasks()->saveMany($tasks);
        });
    }
}
