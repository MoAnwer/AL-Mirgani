<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Teacher extends Model
{
    protected $fillable = [
        'name',
        'phone',
        'salary',
        'rule',
    ];

    public function salaryPayments() : HasMany 
    {
        return $this->hasMany(TeacherSalaryPayment::class);    
    }


    public function advances(): MorphMany
    {
        return $this->morphMany(Advance::class, 'advancer');
    }
    

    public function getFormattedSalaryAttribute() 
    {
        return \Illuminate\Support\Number::currency($this->salary, 'SDG', precision: 0);
    }
}
