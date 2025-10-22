<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Advance extends Model
{
    protected $fillable = [
        'amount', 'date', 'statement'
    ];

    public function advance(): MorphTo 
    {
        return $this->morphTo();
    }
}
