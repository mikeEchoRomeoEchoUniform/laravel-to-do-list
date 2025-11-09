@extends('layouts.app')

@section('title', 'Editar Tarefa')

@section('content')
<div class="card shadow-sm">
  <div class="card-body">
    <h2 class="card-title mb-4 text-center">Editar Tarefa</h2>

    <form action="{{ url("/tasks/{$task->id}") }}" method="POST" class="row g-2">
      @csrf
      @method('PATCH')

      <div class="col-md-8">
        <input type="text" name="title" class="form-control" value="{{ old('title', $task->title) }}" required>
      </div>

      <div class="col-md-4">
        <select name="category" class="form-select">
          <option value="Pessoal" {{ old('category', $task->category) === 'Pessoal' ? 'selected' : '' }}>🏠 Pessoal</option>
          <option value="Trabalho" {{ old('category', $task->category) === 'Trabalho' ? 'selected' : '' }}>💼 Trabalho</option>
          <option value="Estudos" {{ old('category', $task->category) === 'Estudos' ? 'selected' : '' }}>📚 Estudos</option>
          <option value="Saúde" {{ old('category', $task->category) === 'Saúde' ? 'selected' : '' }}>💊 Saúde</option>
        </select>
      </div>

      <div class="col-md-4 mt-2">
        <select name="urgency" class="form-select">
          <option value="Baixa" {{ old('urgency', $task->urgency) === 'Baixa' ? 'selected' : '' }}>🟢 Baixa</option>
          <option value="Média" {{ old('urgency', $task->urgency) === 'Média' ? 'selected' : '' }}>🟡 Média</option>
          <option value="Alta" {{ old('urgency', $task->urgency) === 'Alta' ? 'selected' : '' }}>🔴 Alta</option>
        </select>
      </div>

      @if(\Illuminate\Support\Facades\Schema::hasColumn('tasks','due_date'))
      <div class="col-md-4 mt-2">
        <input type="date" name="due_date" class="form-control" value="{{ old('due_date', $task->due_date ? \Carbon\Carbon::parse($task->due_date)->format('Y-m-d') : '') }}">
      </div>
      @endif

      <div class="col-12 d-flex gap-2 mt-3">
        <button type="submit" class="btn btn-success">Salvar</button>
        <a href="{{ url('/tasks') }}" class="btn btn-secondary">Cancelar</a>
      </div>
    </form>
  </div>
</div>
@endsection