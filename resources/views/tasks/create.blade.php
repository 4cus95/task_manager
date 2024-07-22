@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Создать новую задачку в проекте <b>{{$project->name}}</b></h1>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('projects.tasks.store', ['project' => $project->id]) }}" method="POST">
            @csrf
            <input type="hidden" name="project_id" value="{{$project->id}}">

            <div class="form-group">
                <label for="name">Название</label>
                <input type="text" class="form-control" id="name" name="name" value="{{ old('name') }}" required>
            </div>
            <div class="form-group mb-2">
                <label for="description">Описание</label>
                <textarea class="form-control" id="description" name="description">{{ old('description') }}</textarea>
            </div>
            <button type="submit" class="btn btn-primary">Сохранить</button>
        </form>
    </div>
@endsection
