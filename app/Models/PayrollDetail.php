<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Enums\PayrollItemsTypesEnum;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PayrollDetail extends Model
{
    protected $fillable = [
        'payroll_id',
        'item_id',
        'amount',
        'date',
        'notes',
    ];

    public function payroll(): BelongsTo
    {
        return $this->belongsTo(EmployeePayroll::class, 'payroll_id');
    }

    public function item(): BelongsTo
    {
        return $this->belongsTo(PayrollItem::class, 'item_id');
    }

    public function isAddition() {
        return $this->item->type == PayrollItemsTypesEnum::ADDITION->value;
    }

    public function isDeduction() {
        return $this->item->type == PayrollItemsTypesEnum::DEDUCTION->value;
    }
}