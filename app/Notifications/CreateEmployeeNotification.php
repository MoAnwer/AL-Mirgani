<?php

namespace App\Notifications;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class CreateEmployeeNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Employee $employee) {}

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
            'icon'        => 'bx bx-user-plus',
            'color'       => 'success',
            'title'       => __('notifications.titles.employee_added'),
            'message'     => __('notifications.messages.employee_added', [
                'employee'  => $this->employee->full_name,
            ])
        ];
    }
}
