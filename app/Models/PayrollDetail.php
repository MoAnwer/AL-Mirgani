<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollDetail extends Model
{
    protected $fillable = [
        'payroll_id',
        'item_id',
        'amount',
        'notes',
    ];

    protected function casts(): array {
        return [
            'amount' => 'decimal:2',
        ];
    } 

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(EmployeePayroll::class, 'payroll_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(PayrollItem::class, 'item_id');
    }
}