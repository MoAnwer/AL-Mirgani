<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PayrollItem extends Model
{
    protected $fillable = [
        'name',
        'type', // 'Addition', 'Deduction'
        'is_fixed',
        'default_value',
    ];

    protected function casts(): array {
        return [
            'is_fixed' => 'boolean',
        ];
    }

    // Note: No direct relationships defined here, as this table primarily stores definitions.
}