<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class MeetingStatusNotification extends Notification
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
        $newStatus = ucwords(Str::replace('_', ' ', $this->meeting->status));

        return [
            'type' => 'meeting_status',
            'meeting_id' => $this->meeting->id,
            'icon' => 'ti ti-briefcase',
            'title' => 'Meeting Status',
            'message' => "The meeting {$this->meeting->title} status changed to {$newStatus}."
        ];
    }
}
