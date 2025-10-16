<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherSalaryPayment extends Model
{
    protected $fillable = [
        'teacher_id',
        'amount',
        'payment_date',
        'month',
        'statement',
        'signature_state'
    ];

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(Teacher::class)->withDefault([
            'amount' => '', 
            'payment_date' => '',
            'month' => '',
            'statement' => '',
            'signature_state' => ''
        ]);
    }
}
