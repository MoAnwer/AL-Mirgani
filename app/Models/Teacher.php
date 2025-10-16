<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'salary',
        'rule',
    ];

    public function salaryPayment() : HasMany 
    {
        return $this->hasMany(TeacherSalaryPayment::class);    
    }

}
