<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Earning extends Model
{
    use ReadableHumanDate;

    protected $fillable = ['amount', 'date', 'statement', 'school_id', 'payment_method', 'transaction_id'];

    protected function casts(): array
    {
        return [
            'date' => 'date'
        ];
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    protected function getFormattedAmountAttribute()
    {
        return number_format($this->amount) .' '. __('app.currency');
    }
}
