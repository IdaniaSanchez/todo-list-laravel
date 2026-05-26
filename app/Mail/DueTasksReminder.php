<?php

namespace App\Mail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class DueTasksReminder extends Mailable
{
    use Queueable, SerializesModels;

    public $user;
    public $tasks;

    /**
     * Create a new message instance.
     */
    public function __construct(User $user, $tasks)
    {
        $this->user = $user;
        $this->tasks = $tasks;
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '⚠️ Recordatorio: ¡Tienes tareas que vencen hoy!',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.due-tasks',
        );
    }
}
