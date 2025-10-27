<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Lista de Tarefas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light p-4">
    <div class="container">
        <h1 class="mb-4 text-center">📝 Lista de Tarefas</h1>

        <form action="/tasks" method="POST" class="mb-3 d-flex">
            @csrf
            <input type="text" name="title" class="form-control me-2" placeholder="Nova tarefa..." required>
            <button type="submit" class="btn btn-primary">Adicionar</button>
        </form>

        <ul class="list-group">
            @foreach ($tasks as $task)
                <li class="list-group-item d-flex justify-content-between align-items-center">
                    <form action="/tasks/{{ $task->id }}" method="POST" style="display: inline;">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-sm {{ $task->completed ? 'btn-success' : 'btn-outline-success' }}">
                            {{ $task->completed ? '✔' : 'Marcar' }}
                        </button>
                    </form>

                    <span class="{{ $task->completed ? 'text-decoration-line-through text-muted' : '' }}">
                        {{ $task->title }}
                    </span>

                    <form action="/tasks/{{ $task->id }}" method="POST" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-danger">Excluir</button>
                    </form>
                </li>
            @endforeach
        </ul>
    </div>
</body>
</html>
