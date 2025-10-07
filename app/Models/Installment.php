<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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
}
