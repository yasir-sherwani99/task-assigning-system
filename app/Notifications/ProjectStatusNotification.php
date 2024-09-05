<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class ProjectStatusNotification extends Notification
{
    use Queueable;

    protected $project;

    /**
     * Create a new notification instance.
     */
    public function __construct($project)
    {
        $this->project = $project;
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
        $newStatus = ucwords(Str::replace('_', ' ', $this->project->status));

        return [
            'type' => 'project_status',
            'project_id' => $this->project->id,
            'icon' => 'ti ti-presentation',
            'title' => 'Project Status',
            'message' => "Project {$this->project->name} status changed to {$newStatus}."    
        ];
    }
}
