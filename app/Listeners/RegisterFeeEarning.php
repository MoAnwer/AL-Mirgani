<?php

namespace App\Listeners;

use App\Events\Student\RegisterStudent;
use App\Models\Earning;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class RegisterFeeEarning
{
    /**
     * Create the event listener.
     */
    public function __construct() {}

    /**
     * Handle the event.
     */
    public function handle(RegisterStudent $event): void
    {
        Earning::create([
            'amount'    => $event->student->registrationFees->paid_amount,
            'school_id' => $event->student->school->id,
            'date'      => now()
        ]);
    }
}
