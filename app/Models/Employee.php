<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Employee extends Model
{
    protected $fillable = [
        'full_name',
        'phone_number',
        'hire_date',
        'salary',
        'department',
    ];

    public function payrolls() : HasMany
    {
        return $this->hasMany(EmployeePayroll::class);
    }

    public function getFormattedSalaryAttribute() {
        return number_format($this->salary, 0);
    }
}
