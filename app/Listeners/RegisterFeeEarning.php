<?php

namespace App\Listeners;

use App\Events\Student\RegisterStudent;
use App\Models\Earning;
use App\Models\User;
use App\Notifications\EarningNotification;
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
            'school_id' => $event->student->school?->id,
            'payment_method' => $event->student->registrationFees->payment_method,
            'transaction_id' => $event->student->registrationFees->transaction_id,
            'statement' => __('app.student_registration_fee'),
            'date'      => $event->student->registrationFees?->payment_date
        ]);
        
        User::chunk(100, function($user) use($earning) {
            Notification::send($user, new EarningNotification($earning));
        });
    }
}
