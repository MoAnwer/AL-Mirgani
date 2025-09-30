<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    use ReadableHumanDate;

    protected $fillable = ['amount', 'date', 'statement', 'school_id'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }


    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount) . ' جنية ';
    }
}
