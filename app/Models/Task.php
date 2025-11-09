<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Task extends Model
{
    use HasFactory;

    // Adicionamos 'due_date' no fillable para uso futuro, mas não quebra nada se não existir
    protected $fillable = ['title', 'completed', 'category', 'urgency', 'due_date'];

    protected $casts = [
        'completed' => 'boolean',
        'due_date' => 'datetime', // se a coluna não existir, isso não gera erro
    ];

    /**
     * Retorna true se a tarefa está atrasada:
     * - tem due_date definida
     * - a data já passou
     * - e ainda não está concluída
     */
    public function isOverdue(): bool
    {
        if (!$this->due_date) return false;
        if ($this->completed) return false;
        return $this->due_date->isPast();
    }

    /**
     * Retorna uma descrição amigável do prazo
     * Ex: "Sem prazo", "Atrasada há 2 dias", "Vence amanhã", "Faltam 3 dias"
     */
    public function dueStatus(): string
    {
        if (!$this->due_date) return 'Sem prazo';

        $now = Carbon::now();

        if ($this->completed) {
            return 'Concluída';
        }

        if ($this->isOverdue()) {
            $diff = $this->due_date->diffForHumans($now, true);
            return "Atrasada há {$diff}";
        }

        $diff = $now->diffForHumans($this->due_date, true);
        $days = $now->diffInDays($this->due_date, false);

        if ($days === 0) {
            $hours = $now->diffInHours($this->due_date, false);
            if ($hours > 0) return "Vence em {$hours} hora" . ($hours > 1 ? 's' : '');
            return "Vence hoje";
        }

        if ($days === 1) return "Vence amanhã";

        return "Faltam {$diff}";
    }

    /**
     * Retorna diferença detalhada (em dias, horas, minutos)
     */
    public function dueDiff()
    {
        if (!$this->due_date) return null;

        $now = Carbon::now();

        return [
            'days' => $now->diffInDays($this->due_date, false),
            'hours' => $now->diffInHours($this->due_date, false),
            'minutes' => $now->diffInMinutes($this->due_date, false),
        ];
    }
}