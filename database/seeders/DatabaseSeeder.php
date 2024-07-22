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
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $users = User::factory(3)->create();
        $users->each(function ($user) {
            $count = rand(1, 3);

            $projects = Project::factory($count)->create([
                'user_id' => $user->id
            ]);

            $projects->each(function ($project) {
                $count = rand(1, 3);

                $tasks = Task::factory($count)->create([
                    'project_id' => $project->id
                ]);

                $tasks->each(function ($task) {
                    $count = rand(1, 8);
                    $user = $task->project->user;

                    Timer::factory($count)->create([
                        'user_id' => $user->id,
                        'task_id' => $task->id,
                    ]);
                });
            });
        });

        $this->calculateTasksTime();
    }

    /*
     * Считаем время в задачах по таймерам
     * */
    private function calculateTasksTime() {
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
