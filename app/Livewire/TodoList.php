<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Task;
use App\Models\Category;

class TodoList extends Component
{
    // Variables para el formulario de tareas
    public $title = '';
    public $category_id = '';
    public $priority = 'Media';
    public $due_date = '';

    // Variables para crear categorías
    public $newCategoryName = '';
    public $newCategoryColor = '#3b82f6';

    // Variables de control, búsqueda y filtros
    public $search = '';
    public $filter = 'all';

    // Variables estadísticas que pide tu vista
    public $totalTasks = 0;
    public $completedTasks = 0;

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'category_id' => 'required|exists:categories,id',
        'priority' => 'required|in:Alta,Media,Baja',
        'due_date' => 'nullable|date',
    ];

    /**
     * Agregar una nueva tarea
     */
    public function addTask()
    {
        $this->validate();

        Task::create([
            'title' => $this->title,
            'category_id' => $this->category_id,
            'user_id' => auth()->id(),
            'priority' => $this->priority,
            'due_date' => $this->due_date ? \Carbon\Carbon::parse($this->due_date) : null,
            'is_completed' => false,
        ]);

        $this->reset(['title', 'category_id', 'priority', 'due_date']);
        session()->flash('message', '¡Tarea agregada con éxito!');
    }

    /**
     * Agregar una nueva categoría desde la interfaz
     */
    public function addCategory()
    {
        $this->validate([
            'newCategoryName' => 'required|min:2|max:50',
            'newCategoryColor' => 'required|string|size:7',
        ]);

        Category::create([
            'name' => $this->newCategoryName,
            'color' => $this->newCategoryColor,
        ]);

        $this->reset(['newCategoryName']);
        $this->newCategoryColor = '#3b82f6';
    }

    /**
     * Alternar el estado de completado de la tarea
     */
    public function toggleTask($id)
    {
        $task = Task::where('user_id', auth()->id())->find($id);
        if ($task) {
            $task->update([
                'is_completed' => !$task->is_completed
            ]);
        }
    }

    /**
     * Eliminar una tarea individual
     */
    public function deleteTask($id)
    {
        $task = Task::where('user_id', auth()->id())->find($id);
        if ($task) {
            $task->delete();
        }
    }

    /**
     * PUNTO 4: LIMPIAR TODAS LAS TAREAS COMPLETADAS DE UN SOLO GOLPE
     */
    public function clearCompleted()
    {
        Task::where('user_id', auth()->id())
            ->where('is_completed', true)
            ->delete();

        session()->flash('message', '¡Se limpiaron todas las tareas completadas!');
    }

    /**
     * Renderizar la vista procesando filtros y contadores
     */
    public function render()
    {
        // 1. Base de la consulta vinculando la relación category
        $query = Task::where('user_id', auth()->id())->with('category');

        // 2. Calcular estadísticas globales del usuario antes de aplicar filtros de visualización
        $this->totalTasks = Task::where('user_id', auth()->id())->count();
        $this->completedTasks = Task::where('user_id', auth()->id())->where('is_completed', true)->count();

        // 3. Aplicar buscador por título si existe texto escrito
        if (!empty($this->search)) {
            $query->where('title', 'like', '%' . $this->search . '%');
        }

        // 4. Aplicar filtros de pestañas (Todas, Pendientes, Completadas)
        if ($this->filter === 'pending') {
            $query->where('is_completed', false);
        } elseif ($this->filter === 'completed') {
            $query->where('is_completed', true);
        }

        return view('livewire.todo-list', [
            'tasks' => $query->latest()->get(),
            'categories' => Category::all(),
        ]);
    }
}
