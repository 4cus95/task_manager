<?php

namespace App\Models;

use App\Helpers\TimeHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'user_id'
    ];

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getTotalTimeAttribute()
    {
        $totalTime = $this->tasks->sum(function ($task) {
            return $task->seconds_spent;
        }) ?: 0;

        return TimeHelper::secondsToFormatTime($totalTime);
    }
}
