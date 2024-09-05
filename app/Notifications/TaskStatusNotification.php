<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class TaskStatusNotification extends Notification
{
    use Queueable;

    protected $task;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task = $task;
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
        $newStatus = ucwords(Str::replace('_', ' ', $this->task->status));

        return [
            'type' => 'task_status',
            'task_id' => $this->task->id,
            'icon' => 'ti ti-file-check',
            'title' => 'Task Status',
            'message' => "Task {$this->task->name} status changed to {$newStatus}."    
        ];
    }
}
