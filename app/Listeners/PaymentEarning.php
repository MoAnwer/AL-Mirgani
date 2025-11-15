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
            'statement' => $event->payment->statement,
            'date'      => now()
        ]);

        Notification::send(User::all(), new EarningNotification($earning));
    }
}
