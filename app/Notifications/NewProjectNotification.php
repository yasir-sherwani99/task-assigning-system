<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewProjectNotification extends Notification
{
    use Queueable;

    protected $project_id;
    protected $project_name;
    protected $client_name;
    protected $start_date;
    protected $end_date;

    /**
     * Create a new notification instance.
     */
    public function __construct($project)
    {
        $this->project_id = $project->id;
        $this->project_name = $project->name;
        $this->client_name = $project->clients->first_name . ' ' . $project->clients->last_name;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
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
            'type' => 'new_project',
            'project_id' => $this->project_id,
            'project_name' => $this->project_name,
            'start_date' => $this->client_name,
            'end_date' => $this->end_date     
        ];
    }
}
