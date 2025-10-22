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

    public function getFormattedAmountAttribute() 
    {
        return \Illuminate\Support\Number::currency($this->amount, 'SDG', precision: 0);
    }

    public function getRemainingAttribute()
    {
        return $this->teacher->salary - $this->amount;
    }


    public function getFormattedRemainingAttribute()
    {
        return \Illuminate\Support\Number::currency($this->teacher->salary - $this->amount, 'SDG', precision: 0);
    }
}
