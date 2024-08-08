<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use App\Services\ProjectService;
use App\Services\TaskService;
use App\Services\TimerService;

class DatabaseSeeder extends Seeder
{
    protected $projectService;
    protected $taskService;
    protected $timerService;

    public function __construct(ProjectService $projectService, TaskService $taskService, TimerService $timerService)
    {
        $this->projectService = $projectService;
        $this->taskService = $taskService;
        $this->timerService = $timerService;
    }

    public function run(): void
    {
        $users = User::factory(config('seeder.users_count'))->create();

        $projectService = $this->projectService;
        $taskService = $this->taskService;
        $timerService = $this->timerService;

        $users->each(function ($user) use ($projectService, $taskService, $timerService) {
            $projectService->createProjectsForUser($user);
            $taskService->createTasksForProjects($user->projects);
            $timerService->createTimersForTasks($user->projects->flatMap->tasks);
        });

        $this->timerService->calculateTasksTime();
    }
}
