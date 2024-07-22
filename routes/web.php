<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\TaskController;
use App\Http\Controllers\TimerController;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::middleware(['auth'])->group(function () {
    Route::prefix('/projects/{project}/tasks/{task}')->group(function () {
        Route::get('/start', [TimerController::class, 'start'])->name('start.timer');
        Route::get('/stop', [TimerController::class, 'stop'])->name('stop.timer');
    });

    Route::resource('projects', ProjectController::class);
    Route::resource('projects.tasks', TaskController::class)->except(['index']);
});
