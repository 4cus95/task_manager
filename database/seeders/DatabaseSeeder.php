<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use App\Models\Task;
use Illuminate\Database\Seeder;
use App\Models\Timer;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    private const MIN_COUNT = 1;
    private const MAX_COUNT = 3;

    public function run(): void
    {
        $users = User::factory(self::MAX_COUNT)->create();
        $users->each(function ($user) {
            $count = rand(self::MIN_COUNT, self::MAX_COUNT);

            $projects = Project::factory($count)->make();
            $user->projects()->saveMany($projects);

            $this->insertTasks($projects);
        });

        $this->calculateTasksTime();
    }

    private function insertTasks($projects)
    {
        $projects->each(function ($project) {
            $count = rand(self::MIN_COUNT, self::MAX_COUNT);
            $tasks = Task::factory($count)->make();
            $project->tasks()->saveMany($tasks);

            $this->insertTimers($tasks);
        });
    }

    private function insertTimers($tasks)
    {
        $tasks->each(function ($task) {
            $count = rand(self::MIN_COUNT, self::MAX_COUNT);

            $timers = Timer::factory($count)->make([
                'user_id' => $task->project->user,
            ]);

            $task->timers()->saveMany($timers);
        });
    }

    /*
     * Считаем время в задачах по таймерам
     * */
    private function calculateTasksTime()
    {
        $tasks = Task::all();
        foreach ($tasks as $task) {
            $seconds_wasted = 0;

            $timers = $task->timers;
            foreach ($timers as $timer) {
                $diff = $timer->started_at->diff($timer->ended_at);
                $seconds_wasted += (int)$diff->totalSeconds;
            }

            $task->update([
                'seconds_spent' => $seconds_wasted
            ]);
        }
    }
}
