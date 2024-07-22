<?php

namespace App\Http\Controllers;

use App\Http\Requests\TaskRequest;
use Illuminate\Http\Request;
use App\Models\Task;
use App\Models\Project;

class TaskController extends Controller
{
    public function create(Project $project)
    {
        return view('tasks.create', compact('project'));
    }

    public function store(TaskRequest $request, Project $project)
    {
        Task::create($request->all());
        return redirect()->route('projects.show', ['project' => $project->id])->with('success', 'Задача создана');
    }

    public function show(Project $project, Task $task)
    {
        $this->authorize('view', $project);

        $timerNotEnded = $task->timers()->where('ended_at', null)->first();
        $bShowStart = is_null($timerNotEnded);

        return view('tasks.show', compact('task', 'project', 'bShowStart'));
    }

    public function edit(Project $project, Task $task)
    {
        $this->authorize('update', $project);
        return view('tasks.edit', compact('task', 'project'));
    }

    public function update(TaskRequest $request, Project $project, Task $task)
    {
        $this->authorize('update', $project);
        $task->update($request->all());

        return redirect()->route('projects.show', $project->id)->with('success', 'Задача обновлена');
    }

    public function destroy(Project $project, Task $task)
    {
        $this->authorize('delete', $project);

        $task->delete();
        return redirect()->route('projects.show', $project->id)->with('success', 'Задача удалена.');
    }
}
