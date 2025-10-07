<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Receipt extends Model
{
    use ReadableHumanDate;

    protected $guarded = [];

    public function installmentPayment(): BelongsTo
    {
        return $this->belongsTo(InstallmentPayment::class);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}
