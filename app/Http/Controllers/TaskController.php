<?php

namespace App\Http\Controllers;

use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use Carbon\Carbon;

class TaskController extends Controller
{
    public function index(Request $request)
    {
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

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'urgency' => 'required|string',
        ];

        // se a coluna due_date existir, valide-a
        if (Schema::hasColumn('tasks', 'due_date')) {
            $rules['due_date'] = 'nullable|date';
        }

        $validated = $request->validate($rules);

        // só atribui due_date se a coluna existir
        $data = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
        ];

        if (Schema::hasColumn('tasks', 'due_date') && array_key_exists('due_date', $validated)) {
            $data['due_date'] = $validated['due_date'];
        }

        Task::create($data);

        return redirect('/tasks')->with('success', 'Tarefa criada com sucesso!');
    }

    public function edit(Task $task)
    {
        return view('tasks.edit', compact('task'));
    }

    public function update(Request $request, Task $task)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'category' => 'required|string',
            'urgency' => 'required|string',
        ];

        if (Schema::hasColumn('tasks', 'due_date')) {
            $rules['due_date'] = 'nullable|date';
        }

        $validated = $request->validate($rules);

        $data = [
            'title' => $validated['title'],
            'category' => $validated['category'],
            'urgency' => $validated['urgency'],
        ];

        if (Schema::hasColumn('tasks', 'due_date') && array_key_exists('due_date', $validated)) {
            $data['due_date'] = $validated['due_date'];
        }

        $task->update($data);

        return redirect('/tasks')->with('success', 'Tarefa atualizada com sucesso!');
    }

    public function toggle(Task $task)
    {
        $task->update(['completed' => !$task->completed]);
        return redirect()->back();
    }

    public function destroy(Task $task)
    {
        $task->delete();
        return redirect('/tasks')->with('success', 'Tarefa excluída com sucesso!');
    }

    // --- gráfico (mantido como antes) ---
    public function chart()
    {
        $tasks = Task::all();

        $concluidas = $tasks->where('completed', true)->count();
        $pendentes = $tasks->where('completed', false)->count();

        $atrasadas = 0;
        if (Schema::hasColumn('tasks', 'due_date')) {
            $atrasadas = $tasks->filter(function ($t) {
                return !$t->completed && $t->due_date && Carbon::parse($t->due_date)->isPast();
            })->count();
        }

        $statusChart = [
            'labels' => ['Concluídas', 'Pendentes', 'Atrasadas'],
            'values' => [$concluidas, $pendentes, $atrasadas],
        ];

        $urgencyCounts = $tasks->groupBy('urgency')->map->count()->toArray();
        $urgOrder = ['Baixa', 'Média', 'Alta'];
        $urgLabels = [];
        $urgValues = [];
        foreach ($urgOrder as $u) {
            $urgLabels[] = $u;
            $urgValues[] = $urgencyCounts[$u] ?? 0;
        }

        $urgencyChart = [
            'labels' => $urgLabels,
            'values' => $urgValues,
        ];

        return view('tasks.chart', compact('statusChart', 'urgencyChart', 'concluidas', 'pendentes', 'atrasadas'));
    }
}