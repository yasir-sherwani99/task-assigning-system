<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewMeetingNotification extends Notification
{
    use Queueable;

    protected $meeting;

    /**
     * Create a new notification instance.
     */
    public function __construct($meeting)
    {
        $this->meeting = $meeting;
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
            'type' => 'new_meeting',
            'meeting_id' => $this->meeting->id,
            'icon' => 'ti ti-briefcase',
            'title' => 'New Meeting',
            'message' => "You have been invited on team meeting on {$this->meeting->start_date} about {$this->meeting->title}."
        ];
    }
}













