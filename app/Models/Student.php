<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory, ReadableHumanDate;

    protected $guarded = [];

    public function registrationFees(): HasOne 
    {
        return $this->hasOne(RegistrationFee::class);  
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function school(): BelongsTo 
    {
        return $this->belongsTo(School::class);
    }
}
