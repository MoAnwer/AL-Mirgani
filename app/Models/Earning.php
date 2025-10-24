<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
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

    protected function getFormattedAmountAttribute()
    {
        return number_format($this->amount, 2);
    }

    public function filterBySchool(int $school_id) {
        return $this->query()->where('school_id', $school_id);
    }
}
