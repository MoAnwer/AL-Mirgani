<?php

namespace App\Listeners;

use App\Events\Student\RegisterStudent;
use App\Models\Earning;
use App\Models\User;
use App\Notifications\EarningNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

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
        $earning = Earning::create([
            'amount'    => $event->student->registrationFees->paid_amount,
            'school_id' => $event->student->school->id,
            'payment_method' => $event->student->registrationFees->payment_method,
            'transaction_id' => $event->student->registrationFees->transaction_id,
            'statement' => __('app.student_registration_fee'),
            'date'      => now()
        ]);
        
        Notification::send(User::all(), new EarningNotification($earning));
    }
}
