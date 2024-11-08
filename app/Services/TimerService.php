<?php

namespace App\Services;


use App\Models\Task;
use App\Models\Timer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimerService
{
    public function createTimersForTasks($tasks): void
    {
        $tasks->each(function ($task) {
            $count = rand(config('seeder.min_count'), config('seeder.max_count'));
            $timers = Timer::factory($count)->make([
                'user_id' => $task->project->user_id,
            ]);
            $task->timers()->saveMany($timers);
        });
    }

    public function stopTracking()
    {
        $timer = Timer::getUserStarted()->first();
        if (!$timer) {
            return;
        }

        $this->stopTimer($timer);
    }

    public function stopTimer(Timer $timer) {
        $timer->update([
            'ended_at' => now()
        ]);
        $timer->refresh();

        /*Обновляем время задачи*/
        $diff = $timer->started_at->diff($timer->ended_at);
        $timer->task->addSeconds((int)$diff->totalSeconds ?: 0);
    }

    public function trackTime(Task $task)
    {
        $this->stopTracking();

        Timer::query()->create([
            'user_id' => Auth::id(),
            'task_id' => $task->id,
            'started_at' => now()
        ]);
    }

    private function updateTaskSecondsSpent(Task $task): void
    {
        $secondsWasted = $task->timers->sum(function ($timer) {
            return $timer->started_at->diffInSeconds($timer->ended_at);
        });

        $task->update(['seconds_spent' => $secondsWasted]);
    }

    public function calculateTasksTime(): void
    {
        Task::with('timers')->chunkById(100, function ($tasks) {
            foreach ($tasks as $task) {
                $this->updateTaskSecondsSpent($task);
            }
        });
    }
}
