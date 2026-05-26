<?php

namespace App\Console\Commands;

use App\Models\User;
use App\Models\Task;
use App\Mail\DueTasksReminder;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendTaskReminders extends Command
{
    protected $signature = 'tasks:send-reminders';
    protected $description = 'Envía un correo electrónico a los usuarios con tareas que vencen hoy';

    public function handle()
    {
        // Forzamos a obtener la fecha de hoy en el mismo formato de la base de datos (YYYY-MM-DD)
        $todayDate = Carbon::today()->toDateString();

        $users = User::all();

        foreach ($users as $user) {
            // Buscamos tareas que coincidan exactamente con la fecha de hoy en formato texto
            $dueTasks = Task::with('category')
                ->where('user_id', $user->id)
                ->whereDate('due_date', $todayDate) // <--- Comparación limpia de fechas
                ->where('is_completed', false)
                ->get();

            if ($dueTasks->count() > 0) {
                Mail::to($user->email)->send(new DueTasksReminder($user, $dueTasks));
                $this->info("Recordatorio enviado con éxito a: {$user->email}");
            } else {
                // Esto nos servirá en la consola para saber si pasó por el usuario pero no halló tareas
                $this->line("Usuario {$user->email} no tiene tareas para hoy ($todayDate).");
            }
        }

        $this->info('Proceso de recordatorios finalizado.');
    }
}
