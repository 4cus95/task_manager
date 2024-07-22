<?php
namespace App\Http\Controllers;

use App\Http\Requests\ProjectRequest;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Auth::user()->projects;
        return view('projects.index', compact('projects'));
    }

    public function create()
    {
        return view('projects.create');
    }

    public function store(ProjectRequest $request)
    {
        Auth::user()->projects()->create($request->all());

        return redirect()->route('projects.index');
    }

    public function show(Project $project)
    {
        $this->authorize('view', $project);

        $tasks = $project->tasks;

        return view('projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(ProjectRequest $request, Project $project)
    {
        $this->authorize('update', $project);
        $project->update($request->all());

        return redirect()->route('projects.index')->with('success', 'Проект успешно обновлён');
    }

    public function destroy(Project $project)
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')->with('success', 'Задача удалена.');
    }
}
