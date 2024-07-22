@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Проект <b>{{ $project->name }}</b></h1>
        <p>{{ $project->description }}</p>

        <p>Общее время проекта: {{$project->getTotalTime()}}</p>
    </div>

    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
    </div>

    <div class="container">
        <div class="d-flex">
            <a href="{{ route('projects.index') }}" class="btn btn-primary me-2">Вернуться к списку проектов</a>
            <a href="{{ route('projects.edit', $project->id) }}" class="btn btn-warning me-2">Редактировать</a>
            <form action="{{ route('projects.destroy', $project->id) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
            </form>
        </div>
    </div>

    <div class="container">
        <h2>Задачи в проекте</h2>
    </div>

    <div class="container">
        @if ($project->tasks->isEmpty())
            <p>Задач нет.</p>
        @else
            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Название</th>
                    <th>Описание</th>
                    <th>Действия</th>
                </tr>
                </thead>
                <tbody>
                @foreach ($project->tasks as $task)
                    <tr>
                        <td>{{ $task->id }}</td>
                        <td>{{ $task->name }}</td>
                        <td>{{ $task->description }}</td>
                        <td>
                            <a href="{{ route('projects.tasks.show', ['project' => $project->id, 'task' => $task->id]) }}" class="btn btn-info">Подробнее</a>
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif

        <a href="{{ route('projects.tasks.create', $project->id) }}" class="btn btn-primary mt-3">Создать новую задачу</a>
    </div>
@endsection
