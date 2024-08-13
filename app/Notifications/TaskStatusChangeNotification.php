<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class TaskStatusChangeNotification extends Notification
{
    use Queueable;

    protected $task_id;
    protected $message;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task_id = $task->id;
        $this->message = "The task {$task->name} status changed to {$task->status}.";
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'type' => 'task_status',
            'task_id' => $this->task_id,
            'message' => $this->message
        ];
    }
}
