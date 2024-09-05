<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewAppointmentNotification extends Notification
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
        $clientName = $this->appointment->clients->first_name . ' ' . $this->appointment->clients->last_name;

        return [
            'type' => 'new_appointment',
            'appointment_id' => $this->appointment->id,
            'icon' => 'ti ti-briefcase',
            'title' => 'New Appointment',
            'message' => "Your new appointment is set with client {$clientName} at {$this->appointment->start_date} about {$this->appointment->title}."
        ];
    }
}
