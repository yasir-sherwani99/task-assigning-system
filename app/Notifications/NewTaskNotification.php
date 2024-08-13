<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewTaskNotification extends Notification
{
    use Queueable;

    protected $task_id;
    protected $task_name;
    protected $project_id;
    protected $project_name;
    protected $start_date;
    protected $end_date;
    protected $priority;

    /**
     * Create a new notification instance.
     */
    public function __construct($task)
    {
        $this->task_id = $task->id;
        $this->task_name = $task->name;
        $this->project_id = $task->project_id;
        $this->project_name = $task->projects->name;
        $this->start_date = $task->start_date;
        $this->end_date = $task->end_date;
        $this->priority = $task->priority;
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
            'type' => 'new_task',
            'task_id' => $this->task_id,
            'task_name' => $this->task_name,
            'project_id' => $this->project_id,
            'project_name' => $this->project_name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'priority' => $this->priority
        ];
    }
}
