<?php

namespace App\Models;

use App\Services\Helpers\TimeHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'user_id'];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalTime()
    {
        $totalTime = $this->tasks->sum(function ($task) {
            return $task->seconds_spent;
        }) ?: 0;

        return TimeHelper::secondsToFormatTime($totalTime);
    }

}
