<?php

namespace App\Services;


use App\Models\Task;
use App\Models\Timer;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class TimerService
{
    private $task = false;

    public function setTask(Task $task) {
        $this->task = $task;
    }

    public function stopTracking()
    {
        $timer = Timer::getUserStarted()->first();
        if (!$timer) {
            return;
        }

        /** @var $timer Timer */
        $timer->update([
            'ended_at' => new Carbon()
        ]);
        $timer->refresh();

        /*Обновляем время задачи*/
        $diff = $timer->started_at->diff($timer->ended_at);
        $timer->task->addSeconds((int)$diff->totalSeconds ?: 0);
    }

    public function trackTime()
    {
        $this->stopTracking();

        if($this->task instanceof Task) {
            Timer::query()->create([
                'user_id' => Auth::id(),
                'task_id' => $this->task->id,
                'started_at' => new Carbon()
            ]);
        }
    }
}
