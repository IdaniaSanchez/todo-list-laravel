<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Tareas Pendientes</title>
</head>
<body style="font-family: Arial, sans-serif; background-color: #f4f4f7; color: #333333; margin: 0; padding: 20px;">
    <div style="max-w: 600px; margin: 0 auto; background-color: #ffffff; padding: 30px; rounded-radius: 8px; box-shadow: 0 4px 6px rgba(0,0,0,0.05);">
        <h2 style="color: #1e3a8a; margin-bottom: 10px;">¡Hola, {{ $user->name }}! 👋</h2>
        <p style="font-size: 16px; line-height: 1.5; color: #4b5563;">
            Este es un recordatorio automático de tu <strong>To-Do List Pro</strong>. Hoy es un día importante y tienes las siguientes tareas por vencer:
        </p>

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">

        <div style="margin-bottom: 20px;">
            @foreach($tasks as $task)
                <div style="padding: 12px; margin-bottom: 10px; background-color: #f9fafb; border-left: 4px solid {{ $task->priority === 'Alta' ? '#ef4444' : ($task->priority === 'Media' ? '#f59e0b' : '#10b981') }}; border-radius: 0 6px 6px 0;">
                    <span style="font-size: 16px; font-weight: bold; color: #1f2937;">
                        {{ $task->priority === 'Alta' ? '🔥 ' : '' }}{{ $task->title }}
                    </span>
                    <br>
                    <span style="font-size: 12px; color: #6b7280; font-weight: 600; text-transform: uppercase;">
                        Categoría: {{ $task->category->name }} | Prioridad: {{ $task->priority }}
                    </span>
                </div>
            @endforeach
        </div>

        <hr style="border: 0; border-top: 1px solid #e5e7eb; margin: 20px 0;">

        <p style="font-size: 14px; color: #6b7280; text-align: center; margin-top: 30px;">
            Organiza tu día y no dejes que se acumulen. ¡Tú puedes hacerlo! 🚀
        </p>
    </div>
</body>
</html>
