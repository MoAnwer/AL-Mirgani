<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\AsCollection;
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
        'school_id'
    ];

    protected function casts(): array
    {
        return [
            'rule' => AsCollection::class
        ];
    }

    public function salaryPayment() : HasMany 
    {
        return $this->hasMany(TeacherSalaryPayment::class);    
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class)->withDefault(['name'  => '']);
    }
}
