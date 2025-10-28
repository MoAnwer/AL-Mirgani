<?php

namespace App\Models;

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
}
