<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

class AppointmentStatusNotification extends Notification
{
    use Queueable;

    protected $appointment;

    /**
     * Create a new notification instance.
     */
    public function __construct($appointment)
    {
        $this->appointment = $appointment;
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
        $newStatus = ucwords(Str::replace('_', ' ', $this->appointment->status));
        $clientName = $this->appointment->clients->first_name . ' ' . $this->appointment->clients->last_name;

        return [
            'type' => 'appointment_status',
            'appointmentid' => $this->appointment->id,
            'icon' => 'ti ti-briefcase',
            'title' => 'Appointment Status',
            'message' => "Your appointment with client {$clientName} status changed to {$newStatus}."
        ];
    }
}
