<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Contracts\Database\Query\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Number;

class Earning extends Model
{
    use ReadableHumanDate;

    protected $fillable = ['amount', 'date', 'statement', 'school_id'];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    protected function getFormattedAmountAttribute()
    {
        return Number::currency($this->amount, 'SDG');
    }
}
