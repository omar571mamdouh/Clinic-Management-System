<?php

namespace App\Notifications;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class AppointmentCreatedNotification extends Notification
{
    use Queueable;

    public function __construct(
        public Appointment $appointment
    ) {}

    public function via(object $notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'title' => 'New Appointment',
            'message' => 'New appointment created for ' . $this->appointment->patient->name,
            'appointment_id' => $this->appointment->id,
        ];
    }

    public function toBroadcast(object $notifiable): BroadcastMessage
    {
        return new BroadcastMessage([
            'title' => 'New Appointment',
            'message' => 'New appointment created for ' . $this->appointment->patient->name,
            'appointment_id' => $this->appointment->id,
        ]);
    }
}