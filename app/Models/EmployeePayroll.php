<?php

namespace App\Models;

use App\Enums\PaymentStatusEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EmployeePayroll extends Model
{
    protected $table = 'employee_payrolls'; 
    
    protected $fillable = [
        'employee_id',
        'month',
        'year',
        'basic_salary_snapshot',
        'total_fixed_allowances',
        'total_variable_additions',
        'total_deductions',
        'net_salary_paid',
        'school_total_cost',
        'payment_status',
        'payment_date',
        'payment_method',
        'transaction_id',
    ];

    protected function casts(): array {
        return [
            'payment_date' => 'date',
        ];
    }

    /**
     * Get the employee who owns the payroll record.
     */
    public function employee(): BelongsTo
    {
        return $this->belongsTo(Employee::class);
    }

    public function details()
    {
        return $this->hasMany(PayrollDetail::class, 'payroll_id');
    }

    public function isPaid(): bool {
        return $this->payment_status == PaymentStatusEnum::PAID->value;
    }

    public function isPending(): bool {
        return $this->payment_status == PaymentStatusEnum::PENDING->value;
    }

    public function isFailed(): bool {
        return $this->payment_status == PaymentStatusEnum::FAILED->value;
    }
}
