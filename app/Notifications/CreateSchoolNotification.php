<?php

namespace App\Notifications;

use App\Models\School;
use Illuminate\Notifications\Notification;

class CreateSchoolNotification extends Notification
{
     /**
     * Create a new notification instance.
     */
    public function __construct(private readonly School $school) {}

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
            'icon'        => 'bx bxs-school',
            'color'       => 'secondary',
            'title'       => __('notifications.titles.new_school_added'),
            'message'     => __('notifications.messages.new_school_added', [
                'school'  => $this->school->name,
            ])
        ];
    }
}
