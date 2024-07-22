@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Редактировать задачу <b>{{$task->name}}</b> в проекте <b>{{$project->name}}</b></h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.tasks.update', ['project' => $project->id, 'task' => $task->id]) }}" method="POST">
            @csrf
            @method('PUT')

            <input type="hidden" name="project_id" value="{{$project->id}}">

            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name', $task->name) }}" required>
            </div>
            <div class="form-group">
                <label for="description">Описание</label>
                <textarea class="form-control" id="description" name="description">{{ old('description', $task->description) }}</textarea>
            </div>
            <div class="d-flex mt-2">
                <a href="{{ route('projects.tasks.show', ['project' => $project->id, 'task' => $task->id]) }}" class="btn btn-primary me-2">Отмена</a>
                <button type="submit" class="btn btn-primary">Сохранить</button>
            </div>
        </form>
    </div>
@endsection
