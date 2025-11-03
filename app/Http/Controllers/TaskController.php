<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    public function index(Request $request){
    $filter = $request->query('filter');
    $q = $request->query('q');

    $query = Task::query();

    if ($filter === 'pending') {
        $query->where('completed', false);
    } elseif ($filter === 'done') {
        $query->where('completed', true);
    }

    if ($q) {
        $query->where('title', 'like', "%{$q}%");
    }

    $tasks = $query->orderBy('created_at', 'desc')->get();

    return view('tasks.index', compact('tasks'));
    }

    public function store(Request $request){
    $request->validate([
        'title' => 'required|string|max:255'
    ]);

    Task::create([
        'title' => $request->title,
        'completed' => false
    ]);

    return redirect('/tasks')->with('success', 'Tarefa adicionada com sucesso!');
    }

    public function edit(Task $task){
    return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task){
    $request->validate([
        'title' => 'required|string|max:255'
    ]);

    $task->update(['title' => $request->title]);

    return redirect('/tasks')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function toggle(Task $task){
    $task->update(['completed' => !$task->completed]);
    return redirect()->back();
    }

    public function destroy(Task $task){
    $task->delete();
    return redirect('/tasks')->with('success', 'Tarefa excluída com sucesso!');
    }

}

{
    //
}
