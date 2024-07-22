<?php

namespace App\Models;

use App\Services\Helpers\TimeHelper;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Task extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'description', 'project_id', 'seconds_spent'];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function timers()
    {
        return $this->hasMany(Timer::class);
    }

    public function getTotalTime()
    {
        return TimeHelper::secondsToFormatTime($this->seconds_spent ?: 0);
    }

    public function addSeconds(int $seconds = 0)
    {
        $secondsSpent = $this->seconds_spent ?: 0;
        $this->update([
            'seconds_spent' => $secondsSpent + $seconds
        ]);
    }
}
