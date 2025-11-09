<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Number;

class Installment extends Model
{
    use ReadableHumanDate;
    
    protected $guarded = [];

    protected function casts(): array 
    {
        return [
            'due_date'  => 'date:Y-m-d',
        ];
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(InstallmentPayment::class);
    }

    public function getRemainingAttribute()
    {
        return (int) $this->amount -  $this->total_payments;
    }

    public function getTotalPaymentsAttribute()
    {
        return $this->payments->sum('paid_amount');
    }
}
