<?php

use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect('/tasks');
});

Route::get('/tasks', [TaskController::class, 'index'])->name('tasks.index');
Route::post('/tasks', [TaskController::class, 'store']);
Route::post('/tasks/{task}/toggle', [TaskController::class, 'toggle']);
Route::delete('/tasks/{task}', [TaskController::class, 'destroy']);
Route::get('/tasks/{task}/edit', [TaskController::class, 'edit']);
Route::patch('/tasks/{task}', [TaskController::class, 'update']);
Route::get('/tasks/chart', [TaskController::class, 'chart'])->name('tasks.chart');