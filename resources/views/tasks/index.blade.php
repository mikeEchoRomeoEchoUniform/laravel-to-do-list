@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-4 text-center">Suas Tarefas</h2>

    <!-- Form adicionar + busca -->
    <div class="row mb-3">
      <div class="col-md-8">
        <form action="{{ url('/tasks') }}" method="POST" class="d-flex">
          @csrf
          <input type="text" name="title" class="form-control me-2" placeholder="Digite uma nova tarefa..." required>
          <button type="submit" class="btn btn-primary">
            <i class="bi bi-plus-circle"></i> Adicionar
          </button>
        </form>
      </div>

      <div class="col-md-4">
        <form method="GET" action="{{ url('/tasks') }}" class="d-flex">
          <input type="text" name="q" value="{{ request('q') }}" class="form-control me-2" placeholder="Buscar...">
          <button class="btn btn-outline-secondary">Buscar</button>
        </form>
      </div>
    </div>

    <!-- Filtros e contador -->
    <div class="d-flex justify-content-between align-items-center mb-3">
      <div>
        <a href="{{ url('/tasks') }}" class="btn btn-outline-secondary btn-sm {{ request('filter') === null ? 'active' : '' }}">Todas</a>
        <a href="{{ url('/tasks?filter=pending') }}" class="btn btn-outline-warning btn-sm {{ request('filter') === 'pending' ? 'active' : '' }}">Pendentes</a>
        <a href="{{ url('/tasks?filter=done') }}" class="btn btn-outline-success btn-sm {{ request('filter') === 'done' ? 'active' : '' }}">Concluídas</a>
      </div>
      <div class="text-muted">Total: {{ $tasks->count() }} tarefas</div>
    </div>

    <!-- Lista -->
    <ul class="list-group">
      @forelse ($tasks as $task)
        <li class="list-group-item d-flex justify-content-between align-items-center">
          <div class="d-flex align-items-center">
            <!-- Marcar como concluída -->
            <form action="{{ url("/tasks/{$task->id}/toggle") }}" method="POST" style="display:inline;">
              @csrf
              <button class="btn btn-sm me-3 {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                {{ $task->completed ? '✔' : 'Marcar' }}
              </button>
            </form>

            <div>
              <div class="task-title {{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                {{ $task->title }}
              </div>
              <small class="text-muted">Criada em {{ $task->created_at->format('d/m/Y H:i') }}</small>
            </div>
          </div>

          <div>
            <a href="{{ url("/tasks/{$task->id}/edit") }}" class="btn btn-sm btn-outline-info me-1">Editar</a>

            <form action="{{ url("/tasks/{$task->id}") }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir esta tarefa?');">
              @csrf
              @method('DELETE')
              <button class="btn btn-sm btn-danger">Excluir</button>
            </form>
          </div>
        </li>
      @empty
        <li class="list-group-item text-center text-muted">Nenhuma tarefa encontrada.</li>
      @endforelse
    </ul>
  </div>
</div>
@endsection