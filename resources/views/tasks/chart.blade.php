@extends('layouts.app')

@section('title', 'Gráficos de Tarefas')

@section('content')
<div class="card shadow-sm mb-4">
  <div class="card-body">
    <h3 class="mb-3 text-center">📊 Estatísticas das Tarefas</h3>

    <div class="row">
      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Status</h5>
            <canvas id="statusChart" width="300" height="300"></canvas>
            <div class="mt-3">
              <span class="me-3">✅ Concluídas: <strong>{{ $concluidas }}</strong></span>
              <span class="me-3">⚙️ Pendentes: <strong>{{ $pendentes }}</strong></span>
              <span>⏰ Atrasadas: <strong>{{ $atrasadas }}</strong></span>
            </div>
          </div>
        </div>
      </div>

      <div class="col-md-6 mb-4">
        <div class="card h-100">
          <div class="card-body text-center">
            <h5 class="card-title">Por Urgência</h5>
            <canvas id="urgencyChart" width="300" height="300"></canvas>
          </div>
        </div>
      </div>
    </div>

    <a href="{{ url('/tasks') }}" class="btn btn-outline-primary">⬅ Voltar</a>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
  // status chart (doughnut)
  (function(){
    const chartData = @json($statusChart);
    const ctx = document.getElementById('statusChart').getContext('2d');
    new Chart(ctx, {
      type: 'doughnut',
      data: {
        labels: chartData.labels,
        datasets: [{
          data: chartData.values,
          backgroundColor: ['#198754', '#f6c23e', '#dc3545']
        }]
      },
      options: { responsive: true, plugins: { legend: { position: 'bottom' } } }
    });
  })();

  // urgency chart (bar)
  (function(){
    const udata = @json($urgencyChart);
    const ctx2 = document.getElementById('urgencyChart').getContext('2d');
    new Chart(ctx2, {
      type: 'bar',
      data: {
        labels: udata.labels,
        datasets: [{
          label: 'Quantidade',
          data: udata.values,
          backgroundColor: ['#198754','#ffc107','#dc3545']
        }]
      },
      options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: { y: { beginAtZero: true, precision: 0 } }
      }
    });
  })();
</script>
@endsection