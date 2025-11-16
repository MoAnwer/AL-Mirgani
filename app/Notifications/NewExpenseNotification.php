<?php

namespace App\Notifications;

use App\Models\Expense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewExpenseNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Expense $expense) {}

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
            'icon'        => 'bx bx-right-arrow-alt',
            'color'       => 'danger',
            'title'       => __('notifications.titles.new_expense'),
            'message'     => __('notifications.messages.new_expense', [
                'amount'  => number_format($this->expense->amount),
                'school'  => $this->expense->school->name
            ])
        ];
    }
}
