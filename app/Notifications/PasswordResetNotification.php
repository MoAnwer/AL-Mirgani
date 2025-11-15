<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Notifications\Notification;

class PasswordResetNotification extends Notification
{
     /**
     * Create a new notification instance.
     */
    public function __construct(private readonly User $user) {}

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
            'icon'        => 'bx bx-lock',
            'color'       => 'warning',
            'title'       => __('notifications.titles.password_reset'),
            'message'     => __('notifications.messages.password_reset', [
                'user'  => $this->user->name,
            ])
        ];
    }
}
