<?php

namespace App\Notifications;

use App\Models\Earning;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class EarningNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Earning $earning) {}

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
            'color'       => 'success',
            'title'       => __('notifications.titles.new_earning'),
            'message'     => __('notifications.messages.new_earning', [
                'amount'  => number_format($this->earning->amount),
                'school'  => $this->earning->school?->name
            ])
        ];
    }
}
