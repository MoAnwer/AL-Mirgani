<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class PayrollPaidNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly array $data)
    {
        //
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
            'icon'        => 'bx bx-money',
            'color'       => 'primary',
            'title'       => __('notifications.titles.payroll_paid'),
            'message'     => __('notifications.messages.payroll_paid', [
                'employee'  => $this->data['employee'],
                'month'     => $this->data['month'],
                'year'      => $this->data['year'],
            ])
        ];
    }
}
