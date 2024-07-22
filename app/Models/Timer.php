<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

class Timer extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = ['task_id', 'user_id', 'started_at', 'ended_at'];

    protected $casts = [
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function scopeGetUserStarted(Builder $builder)
    {
        return $builder->where('user_id', Auth::id())->where('ended_at', null);
    }
}
