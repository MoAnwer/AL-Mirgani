<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SecurityQuestion extends Model
{
    protected $fillable = ['question', 'answer', 'user_id'];

    public function user() : BelongsTo
    {
        return $this->belongsTo(User::class)->withDefault([
            'name'  => '',
            'username'  => ''
        ]);
    }
}
