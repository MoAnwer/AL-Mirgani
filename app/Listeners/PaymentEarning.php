<?php

namespace App\Listeners;

use App\Events\Earning\InstallmentPaymentIsPaid;
use App\Models\Earning;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;

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
        $this->earning->create([
            'amount'    => $event->payment->paid_amount,
            'school_id' => $event->payment->student->school->id,
            'statement' => $event->payment->statement,
            'date'      => now()
        ]);
    }
}
