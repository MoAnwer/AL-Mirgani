<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InstallmentPayment extends Model
{
    use ReadableHumanDate;
    
    protected $guarded = [];

    public function installment(): BelongsTo
    {
        return $this->belongsTo(Installment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

}
