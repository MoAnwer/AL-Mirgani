<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RegistrationFee extends Model
{
    use ReadableHumanDate;
    
    protected $fillable = [
        'student_id',
        'payment_method',
        'payment_date',
        'amount',
        'paid_amount',
        'transaction_id'
    ];

    public function student() : BelongsTo 
    {
        return $this->belongsTo(Student::class);
    }
}
