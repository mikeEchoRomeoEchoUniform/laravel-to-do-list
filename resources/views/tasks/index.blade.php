@extends('layouts.app')

@section('title', 'Lista de Tarefas')

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-4 text-center">📝 Suas Tarefas</h2>

    <!-- Form adicionar -->
    <form action="{{ url('/tasks') }}" method="POST" class="row g-2 mb-4">
      @csrf
      <div class="col-md-4">
        <input type="text" name="title" class="form-control" placeholder="Digite uma nova tarefa..." required>
      </div>

      <div class="col-md-3">
        <select name="category" class="form-select">
          <option value="Pessoal">🏠 Pessoal</option>
          <option value="Trabalho">💼 Trabalho</option>
          <option value="Estudos">📚 Estudos</option>
          <option value="Saúde">💊 Saúde</option>
        </select>
      </div>

      <div class="col-md-3">
        <select name="urgency" class="form-select">
          <option value="Baixa">🟢 Baixa</option>
          <option value="Média" selected>🟡 Média</option>
          <option value="Alta">🔴 Alta</option>
        </select>
      </div>

      <div class="col-md-2">
        @if(\Illuminate\Support\Facades\Schema::hasColumn('tasks', 'due_date'))
          <input type="date" name="due_date" class="form-control">
        @else
          <!-- deixa um input oculto (opcional) para não alterar layout se quiser -->
          <input type="hidden" name="due_date" value="">
        @endif
      </div>

      <div class="col-md-15 d-grid">
        <button type="submit" class="btn btn-primary">
          <i class="bi bi-plus-circle"></i> Adicionar
        </button>
      </div>
    </form>

    <!-- Contador e filtros -->
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <a href="{{ url('/tasks') }}" class="btn btn-outline-secondary btn-sm {{ request('filter') === null ? 'active' : '' }}">Todas</a>
        <a href="{{ url('/tasks?filter=pending') }}" class="btn btn-outline-warning btn-sm {{ request('filter') === 'pending' ? 'active' : '' }}">Pendentes</a>
        <a href="{{ url('/tasks?filter=done') }}" class="btn btn-outline-success btn-sm {{ request('filter') === 'done' ? 'active' : '' }}">Concluídas</a>
      </div>
      <div class="text-muted">Total: {{ $tasks->count() }} tarefas</div>
    </div>

    <!-- Cards de tarefas -->
    <div class="row g-3">
      @forelse ($tasks as $task)
        @php
          $color = match($task->urgency) {
              'Alta' => 'border-danger',
              'Média' => 'border-warning',
              'Baixa' => 'border-success',
              default => 'border-secondary'
          };
          $icon = match($task->category) {
              'Trabalho' => '💼',
              'Estudos' => '📚',
              'Saúde' => '💊',
              default => '🏠'
          };
        @endphp

        <div class="col-md-4">
          <div class="card {{ $color }} border-3 shadow-sm h-100">
            <div class="card-body d-flex flex-column justify-content-between">
              <div>
                <h5 class="card-title {{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                  {{ $icon }} {{ $task->title }}
                </h5>
                <p class="card-text mb-1">
                  <strong>Categoria:</strong> {{ $task->category }}<br>
                  <strong>Urgência:</strong> {{ $task->urgency }}
                </p>
                <small class="text-muted">Criada em {{ $task->created_at->format('d/m/Y H:i') }}</small>
                @php
                  $hasDue = !empty($task->due_date);
                  // seguro: se due_date vier como string, parse; se já for Carbon, parse aceita
                  $dueDate = $hasDue ? \Carbon\Carbon::parse($task->due_date) : null;
                @endphp

                @if($hasDue)
                  @php
                  $now = \Carbon\Carbon::now();
                  $diffDays = $dueDate->diffInDays($now, false); // negative if future? diffInDays with false returns signed
                  // determine class: overdue (red), near (<=2 days -> warning), else success
                  $dueClass = $dueDate->isPast() ? 'text-danger fw-bold' : 'text-success';
                  $diffDays = (int) abs($dueDate->diffInDays($now));
                  $humanPt = $dueDate->isPast()
                    ? "há $diffDays " . \Illuminate\Support\Str::plural('dia', $diffDays)
                    : "em $diffDays " . \Illuminate\Support\Str::plural('dia', $diffDays);

                  @endphp

                <div class="mt-1 small {{ $dueClass }}">
                  Prazo: {{ $dueDate->format('d/m/Y') }} — {{ $humanPt }}
                </div>
                @endif
              </div>

              <div class="d-flex justify-content-between align-items-center mt-3">
                <form action="{{ url("/tasks/{$task->id}/toggle") }}" method="POST">
                  @csrf
                  <button class="btn btn-sm {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                    {{ $task->completed ? '✔ Concluída' : 'Concluída' }}
                  </button>
                </form>

                <div>
                  <a href="{{ url("/tasks/{$task->id}/edit") }}" class="btn btn-sm btn-outline-info me-1">Editar</a>
                  <form action="{{ url("/tasks/{$task->id}") }}" method="POST" style="display:inline;" onsubmit="return confirm('Excluir esta tarefa?');">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-sm btn-danger">Excluir</button>
                  </form>
                </div>
              </div>
            </div>
          </div>
        </div>
      @empty
        <div class="col-12 text-center text-muted">
          Nenhuma tarefa encontrada.
        </div>
      @endforelse
    </div>
  </div>
</div>
@endsection