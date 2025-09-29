<?php

namespace App\Models;

use App\Traits\ReadableHumanDate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Student extends Model
{
    use HasFactory, ReadableHumanDate;

    protected $guarded = [];

    public function registrationFees(): HasOne 
    {
        return $this->hasOne(RegistrationFee::class);  
    }

    public function class(): BelongsTo
    {
        return $this->belongsTo(ClassRoom::class);
    }

    public function school(): BelongsTo 
    {
        return $this->belongsTo(School::class);
    }

    public function healthyHistory(): HasOne
    {
        return $this->hasOne(StudentHealthyHistory::class)->withDefault([
            'diagnosis'     => '', 
            'medication'    => '', 
            'student_id'    => '', 
            'notes'         => ''
        ]);
    }


    public static function generateStudentNumber(): int
    {
        $year   = now()->year;
        $number = (int) Student::whereYear('created_at', $year)->max('student_number');
        if($number) {
            return ++$number;
        }
        return (int)($year . str_pad(++$number, 5, '0', STR_PAD_LEFT));
    }
}
