<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Services\TimerService;

class TimerController extends Controller
{
    public function start(Project $project, Task $task)
    {
        $this->authorize('update', $project);

        TimerService::trackTime($task);

        return redirect()->route('projects.tasks.show', [$project->id, $task->id]);
    }

    public function stop(Project $project, Task $task)
    {
        $this->authorize('update', $project);

        TimerService::stopTracking();

        return redirect()->route('projects.tasks.show', [$project->id, $task->id]);
    }
}
