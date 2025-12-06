<?php

namespace App\Listeners;

use App\Events\Earning\InstallmentPaymentIsPaid;
use App\Models\Earning;
use App\Models\User;
use App\Notifications\EarningNotification;
use Illuminate\Support\Facades\Notification;

class PaymentEarning
{
    /**
     * Create the event listener.
     */
    public function __construct(public Earning $earning) {}

    /**
     * Handle the event.
     */
    public function handle(InstallmentPaymentIsPaid $event): void
    {
        $earning = $this->earning->create([
            'amount'    => $event->payment->paid_amount,
            'school_id' => $event->payment->student->school->id,
            'payment_method' => $event->payment->payment_method,
            'transaction_id' => $event->payment?->transaction_id ?? '',
            'statement' => $event->payment->statement,
            'date'      => $event->payment->payment_date
        ]);

        Notification::send(User::all(), new EarningNotification($earning));
    }
}
