<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Expense extends Model
{
    use ReadableHumanDate;
    
    protected $fillable = [
        'amount',
        'category_id', 
        'school_id', 
        'date', 
        'statement', 
        'user_id'
    ];

    public function category(): BelongsTo 
    {
        return $this->belongsTo(ExpenseCategory::class);
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }


    public function getFormattedAmountAttribute()
    {
        return number_format($this->amount) . ' جنية ';
    }
}
