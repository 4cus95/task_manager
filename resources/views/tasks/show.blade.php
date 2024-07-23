@extends('layouts.app')

@section('content')
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <h1>Задача <b>{{$task->name}}</b> в проекте <b>{{$project->name}}</b></h1>

        <p>{{$task->description}}</p>

        <div class="d-flex">
            <a href="{{ route('projects.show', ['project' => $project->id]) }}" class="btn btn-primary mb-3 me-2">Вернуться к проекту</a>
            <a href="{{ route('projects.tasks.edit', ['project' => $project->id, 'task' => $task->id]) }}" class="btn btn-warning mb-3 me-2">Редактировать</a>
            <form action="{{ route('projects.tasks.destroy', ['project' => $project->id, 'task' => $task->id]) }}" method="POST" style="display:inline-block;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger" onclick="return confirm('Вы уверены?')">Удалить</button>
            </form>
        </div>

        <h2>Трекинг времени</h2>

        <div class="d-flex mb-2">
            <form action="{{ route($bShowStart ? 'start.timer' : 'stop.timer', [$project->id, $task->id]) }}" method="GET" style="display:inline-block;">
                @csrf
                @method('GET')
                <button type="submit"
                        class="btn {{$bShowStart ? 'btn-success' : 'btn-danger'}}"
                >{{$bShowStart ? 'Начать трекинг' : 'Остановить трекинг'}}</button>
            </form>
        </div>

        @if ($task->timers->isEmpty())
            <p>Отметок времени нет.</p>
        @else
            <p>Общее время задачи: {{$task->totalTime}}</p>

            <table class="table table-bordered">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Начало трекинга</th>
                    <th>Окончание трекинга</th>
                    <th>Продолжительность</th>
                </tr>
                </thead>
                <tbody>
                    @foreach ($task->timers->sortByDesc('id') as $timer)
                        <tr>
                            <td>{{ $timer->id }}</td>
                            <td>{{ $timer->started_at }}</td>
                            <td>{{ $timer->ended_at }}</td>
                            @php
                                $diff = $timer->started_at->diff($timer->ended_at);
                            @endphp
                            <td>{{$diff->format('%H:%I:%S')}}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@endsection
