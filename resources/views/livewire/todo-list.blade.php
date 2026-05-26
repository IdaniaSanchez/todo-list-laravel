<div class="max-w-md mx-auto bg-white shadow-lg rounded-lg overflow-hidden mt-10 p-6">
    <h2 class="text-2xl font-bold text-gray-800 mb-4 text-center">To-Do List Pro</h2>

    <form wire:submit.prevent="addTask" class="mb-4">
        <div class="flex flex-col gap-2">
            <input
                type="text"
                wire:model="title"
                placeholder="¿Qué tienes pendiente hoy?"
                class="w-full px-3 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700"
            >
            @error('title') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <div class="grid grid-cols-3 gap-1.5">
                <select wire:model="category_id" class="w-full px-2 py-2 border rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="">Categoría</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>

                <input type="date" wire:model="due_date" class="w-full px-2 py-2 border rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500" title="Fecha de vencimiento">

                <select wire:model="priority" class="w-full px-2 py-2 border rounded-lg text-xs text-gray-600 focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="Baja">Baja</option>
                    <option value="Media">Media</option>
                    <option value="Alta">Alta</option>
                </select>
            </div>
            @error('category_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror

            <button type="submit" class="w-full bg-blue-500 hover:bg-blue-600 text-white py-2 rounded-lg font-medium transition mt-1 text-sm">
                + Agregar Tarea
            </button>
        </div>
    </form>

    <div class="mb-6 p-3 bg-blue-50/50 rounded-lg border border-blue-100">
        <span class="text-xs font-bold text-blue-700 block mb-2 uppercase tracking-wide">Nueva Categoría</span>
        <form wire:submit.prevent="addCategory" class="flex gap-2 items-center">
            <input type="text" wire:model="newCategoryName" placeholder="Ej. Hogar, Gym..." class="w-full px-2 py-1 border text-sm rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400 text-gray-700">
            <input type="color" wire:model="newCategoryColor" class="w-10 h-8 border-0 rounded cursor-pointer bg-transparent">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-3 py-1 text-sm rounded-lg font-medium transition">+</button>
        </form>
        @error('newCategoryName') <span class="text-red-500 text-xs block mt-1">{{ $message }}</span> @enderror
    </div>

    @if($totalTasks > 0)
        <div class="mb-6 bg-gray-50 p-3 rounded-lg border border-gray-100">
            <div class="flex justify-between items-center mb-2">
                <span class="text-sm font-medium text-gray-600">Tu progreso</span>
                <span class="text-sm font-bold text-blue-600">{{ $completedTasks }} de {{ $totalTasks }} completadas</span>
            </div>
            <div class="w-full bg-gray-200 rounded-full h-2.5">
                <div class="bg-blue-500 h-2.5 rounded-full transition-all duration-500" style="width: {{ ($completedTasks / $totalTasks) * 100 }}%"></div>
            </div>
            @if($completedTasks == $totalTasks)
                <p class="text-center text-xs text-green-600 font-medium mt-2">¡Felicidades, completaste todo!</p>
            @endif
        </div>
    @endif

    <div class="mb-4 space-y-2">
        <input type="text" wire:model.live="search" placeholder="Buscar tarea..." class="w-full px-3 py-1.5 border rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-blue-500 text-gray-700">
        <div class="flex justify-between gap-1">
            <button wire:click="$set('filter', 'all')" class="w-full text-xs py-1.5 rounded-md font-medium transition {{ $filter === 'all' ? 'bg-blue-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Todas</button>
            <button wire:click="$set('filter', 'pending')" class="w-full text-xs py-1.5 rounded-md font-medium transition {{ $filter === 'pending' ? 'bg-blue-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Pendientes</button>
            <button wire:click="$set('filter', 'completed')" class="w-full text-xs py-1.5 rounded-md font-medium transition {{ $filter === 'completed' ? 'bg-blue-500 text-white shadow' : 'bg-gray-100 text-gray-600 hover:bg-gray-200' }}">Completadas</button>
        </div>
    </div>

    <div class="space-y-3">
        @forelse($tasks as $task)
            <div class="flex flex-col p-3 border-l-4 rounded-r-lg border-y border-r hover:bg-gray-50 transition gap-1
                {{ $task->priority === 'Alta' && !$task->is_completed ? 'border-l-red-500 bg-red-50/10' : '' }}
                {{ $task->priority === 'Media' && !$task->is_completed ? 'border-l-yellow-500' : '' }}
                {{ $task->priority === 'Baja' && !$task->is_completed ? 'border-l-green-500' : '' }}
                {{ $task->is_completed ? 'border-l-gray-300 bg-gray-50/50' : '' }}">

                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <input type="checkbox" wire:click="toggleTask({{ $task->id }})" {{ $task->is_completed ? 'checked' : '' }} class="w-5 h-5 text-blue-600 rounded focus:ring-blue-500 cursor-pointer">

                        <span class="{{ $task->is_completed ? 'line-through text-gray-400' : 'text-gray-800' }} font-medium">
                            {!! $task->priority === 'Alta' && !$task->is_completed ? '' : '' !!}{{ $task->title }}
                        </span>

                        <span class="text-xs px-2 py-0.5 rounded-full text-white font-semibold" style="background-color: {{ $task->category->color }}">
                            {{ $task->category->name }}
                        </span>
                    </div>

                    <button wire:click="deleteTask({{ $task->id }})" class="text-red-500 hover:text-red-700 p-1 transition">Eliminar</button>
                </div>

                @if($task->due_date)
                    <div class="flex items-center gap-2 pl-8 text-xs mt-0.5">
                        <span class="text-gray-500">Vence: {{ $task->due_date->format('d/m/Y') }}</span>
                        @if($task->due_date->isPast() && !$task->is_completed)
                            <span class="text-red-600 font-bold bg-red-50 px-1.5 py-0.5 rounded border border-red-200 animate-pulse">¡Retrasada!</span>
                        @endif
                    </div>
                @endif
            </div>
        @empty
            <p class="text-center text-gray-500 py-4">No se encontraron tareas.</p>
        @endforelse
    </div>
</div>
