<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewDefectNotification extends Notification
{
    use Queueable;

    protected $defect;

    /**
     * Create a new notification instance.
     */
    public function __construct($defect)
    {
        $this->defect = $defect;
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
            'type' => 'new_defect',
            'defect_id' => $this->defect->id,
            'icon' => 'ti ti-bug',
            'title' => 'New Defect',
            'message' => "A new defect {$this->defect->name} of type {$this->defect->type} is created and assigned to {$this->defect->teams->name}." 
        ];
    }
}











